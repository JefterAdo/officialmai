<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SeoAiService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.groq.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
    }

    public function analyzeSeo($content, $title, $metaDescription)
    {
        $prompt = $this->buildSeoPrompt($content, $title, $metaDescription);
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'llama3-70b-8192',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert SEO analyst specialized in content optimization. Analyze the content and provide detailed recommendations based on current SEO best practices.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            if ($response->successful()) {
                return $this->formatSeoAnalysis($response->json());
            }

            return [
                'success' => false,
                'message' => 'Error analyzing content',
                'error' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error connecting to Groq API',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function buildSeoPrompt($content, $title, $metaDescription)
    {
        return <<<EOT
Please analyze the following content for SEO optimization:

Title: {$title}
Meta Description: {$metaDescription}
Content: {$content}

Provide a detailed analysis including:
1. Keyword Analysis:
   - Main keyword identification
   - Keyword density and placement
   - LSI keywords suggestions
2. Title Optimization:
   - Title tag effectiveness
   - H1, H2, H3 structure
3. Meta Description Analysis:
   - Length and relevance
   - Call-to-action effectiveness
4. Content Quality:
   - Length and depth
   - Readability score
   - Content structure
5. Internal/External Linking:
   - Link opportunities
   - Anchor text suggestions
6. Image Optimization:
   - Alt text recommendations
   - Image compression needs
7. Technical SEO:
   - Mobile optimization suggestions
   - Page speed impact factors
8. Voice Search Optimization:
   - Natural language usage
   - Question-based content opportunities

For each category, provide:
- Current score (0-100)
- Specific improvements needed
- Practical implementation suggestions
- Priority level (High/Medium/Low)
EOT;
    }

    protected function formatSeoAnalysis($response)
    {
        $analysis = $response['choices'][0]['message']['content'];
        
        // Structure the analysis into a more usable format
        return [
            'success' => true,
            'analysis' => $analysis,
            'structured_data' => $this->parseAnalysisIntoStructuredData($analysis)
        ];
    }

    protected function parseAnalysisIntoStructuredData($analysis)
    {
        // Parse the free-form analysis into structured data
        // This is a simplified version - you might want to enhance this based on your needs
        $categories = [
            'keyword_analysis',
            'title_optimization',
            'meta_description',
            'content_quality',
            'linking',
            'image_optimization',
            'technical_seo',
            'voice_search'
        ];

        $structured = [];
        foreach ($categories as $category) {
            if (preg_match("/$category.*?score.*?(\d+)/i", $analysis, $matches)) {
                $structured[$category] = [
                    'score' => (int) $matches[1],
                    'recommendations' => $this->extractRecommendations($analysis, $category)
                ];
            }
        }

        return $structured;
    }

    protected function extractRecommendations($analysis, $category)
    {
        // Extract specific recommendations for each category
        // This is a simplified version - enhance based on your needs
        $recommendations = [];
        if (preg_match("/$category.*?recommendations:(.*?)(?=\n\n|\Z)/si", $analysis, $matches)) {
            $recommendations = array_filter(
                array_map(
                    'trim',
                    explode("\n", trim($matches[1]))
                )
            );
        }
        return $recommendations;
    }
} 