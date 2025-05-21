<?php

namespace App\Adapters;

use Cloudinary\Cloudinary;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToWriteFile;

class CloudinaryAdapter implements FilesystemAdapter
{
    protected Cloudinary $cloudinary;
    protected string $folder;

    public function __construct(Cloudinary $cloudinary, string $folder = '')
    {
        $this->cloudinary = $cloudinary;
        $this->folder = $folder;
    }

    public function fileExists(string $path): bool
    {
        try {
            $result = $this->cloudinary->adminApi()->asset($this->getPublicId($path));
            return isset($result['public_id']);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function directoryExists(string $path): bool
    {
        try {
            $result = $this->cloudinary->adminApi()->subFolders($path);
            return !empty($result);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function write(string $path, string $contents, Config $config): void
    {
        try {
            $tempFile = tempnam(sys_get_temp_dir(), 'cloudinary');
            file_put_contents($tempFile, $contents);
            
            $options = [
                'public_id' => $this->getPublicId($path),
                'overwrite' => true,
            ];
            
            if (!empty($this->folder)) {
                $options['folder'] = $this->folder;
            }
            
            $this->cloudinary->uploadApi()->upload($tempFile, $options);
            unlink($tempFile);
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        try {
            $tempFile = tempnam(sys_get_temp_dir(), 'cloudinary');
            $stream = fopen($tempFile, 'w+');
            stream_copy_to_stream($contents, $stream);
            fclose($stream);
            
            $options = [
                'public_id' => $this->getPublicId($path),
                'overwrite' => true,
            ];
            
            if (!empty($this->folder)) {
                $options['folder'] = $this->folder;
            }
            
            $this->cloudinary->uploadApi()->upload($tempFile, $options);
            unlink($tempFile);
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function read(string $path): string
    {
        try {
            $url = $this->cloudinary->image($this->getPublicId($path))->toUrl();
            $contents = file_get_contents($url);
            
            if ($contents === false) {
                throw new \Exception("Unable to read file at {$url}");
            }
            
            return $contents;
        } catch (\Exception $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    public function readStream(string $path)
    {
        try {
            $url = $this->cloudinary->image($this->getPublicId($path))->toUrl();
            $stream = fopen($url, 'r');
            
            if ($stream === false) {
                throw new \Exception("Unable to open stream for {$url}");
            }
            
            return $stream;
        } catch (\Exception $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    public function delete(string $path): void
    {
        try {
            $this->cloudinary->uploadApi()->destroy($this->getPublicId($path));
        } catch (\Exception $e) {
            // Ignorer les erreurs si le fichier n'existe pas
        }
    }

    public function deleteDirectory(string $path): void
    {
        try {
            $this->cloudinary->adminApi()->deleteFolder($path);
        } catch (\Exception $e) {
            // Ignorer les erreurs si le dossier n'existe pas
        }
    }

    public function createDirectory(string $path, Config $config): void
    {
        try {
            $this->cloudinary->adminApi()->createFolder($path);
        } catch (\Exception $e) {
            // Ignorer les erreurs si le dossier existe déjà
        }
    }

    public function visibility(string $path): FileAttributes
    {
        // Cloudinary est toujours public
        return new FileAttributes($path, null, 'public');
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // Cloudinary ne supporte pas les changements de visibilité
    }

    public function mimeType(string $path): FileAttributes
    {
        try {
            $result = $this->cloudinary->adminApi()->asset($this->getPublicId($path));
            
            if (!isset($result['resource_type'])) {
                throw new \Exception("Unable to determine mime type for {$path}");
            }
            
            // Conversion basique du type de ressource Cloudinary en MIME type
            $mimeType = 'application/octet-stream';
            
            if ($result['resource_type'] === 'image') {
                $mimeType = 'image/' . ($result['format'] ?? 'jpeg');
            } elseif ($result['resource_type'] === 'video') {
                $mimeType = 'video/' . ($result['format'] ?? 'mp4');
            } elseif ($result['resource_type'] === 'raw') {
                $mimeType = 'application/' . ($result['format'] ?? 'octet-stream');
            }
            
            return new FileAttributes($path, null, null, null, $mimeType);
        } catch (\Exception $e) {
            throw UnableToRetrieveMetadata::mimeType($path, $e->getMessage(), $e);
        }
    }

    public function lastModified(string $path): FileAttributes
    {
        try {
            $result = $this->cloudinary->adminApi()->asset($this->getPublicId($path));
            
            if (!isset($result['created_at'])) {
                throw new \Exception("Unable to determine last modified time for {$path}");
            }
            
            $timestamp = strtotime($result['created_at']);
            
            return new FileAttributes($path, null, null, $timestamp);
        } catch (\Exception $e) {
            throw UnableToRetrieveMetadata::lastModified($path, $e->getMessage(), $e);
        }
    }

    public function fileSize(string $path): FileAttributes
    {
        try {
            $result = $this->cloudinary->adminApi()->asset($this->getPublicId($path));
            
            if (!isset($result['bytes'])) {
                throw new \Exception("Unable to determine file size for {$path}");
            }
            
            return new FileAttributes($path, $result['bytes']);
        } catch (\Exception $e) {
            throw UnableToRetrieveMetadata::fileSize($path, $e->getMessage(), $e);
        }
    }

    public function listContents(string $path, bool $deep): iterable
    {
        try {
            $prefix = empty($path) ? '' : rtrim($path, '/') . '/';
            $options = ['prefix' => $prefix, 'max_results' => 500];
            
            $result = $this->cloudinary->adminApi()->assets($options);
            
            foreach ($result['resources'] as $resource) {
                $resourcePath = $resource['public_id'];
                
                if (isset($resource['folder'])) {
                    $resourcePath = $resource['folder'] . '/' . $resource['public_id'];
                }
                
                yield new FileAttributes(
                    $resourcePath,
                    $resource['bytes'] ?? null,
                    'public',
                    isset($resource['created_at']) ? strtotime($resource['created_at']) : null
                );
            }
            
            if (!$deep) {
                return;
            }
            
            // Lister les sous-dossiers si demandé
            $folders = $this->cloudinary->adminApi()->subFolders($path);
            
            foreach ($folders['folders'] as $folder) {
                yield from $this->listContents($folder['path'], $deep);
            }
        } catch (\Exception $e) {
            // Retourner un tableau vide en cas d'erreur
            return [];
        }
    }

    public function move(string $source, string $destination, Config $config): void
    {
        try {
            $content = $this->read($source);
            $this->write($destination, $content, $config);
            $this->delete($source);
        } catch (\Exception $e) {
            throw new FilesystemException("Unable to move file from {$source} to {$destination}", $e->getCode(), $e);
        }
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        try {
            $content = $this->read($source);
            $this->write($destination, $content, $config);
        } catch (\Exception $e) {
            throw new FilesystemException("Unable to copy file from {$source} to {$destination}", $e->getCode(), $e);
        }
    }

    protected function getPublicId(string $path): string
    {
        // Supprimer l'extension du fichier pour le public_id
        $pathInfo = pathinfo($path);
        $publicId = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' . $pathInfo['filename'] : $pathInfo['filename'];
        $publicId = ltrim($publicId, './');
        
        return $publicId;
    }
}
