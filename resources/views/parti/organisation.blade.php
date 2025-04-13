@extends('layouts.app')

@section('title', 'Structure et Organisation du RHDP | Organisation du Parti')

@push('styles')
<style>
    .org-section {
        margin-bottom: 3rem;
    }
    .org-card {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #FF8C00;
    }
    .org-card h3 {
        color: #FF8C00;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }
    .org-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 2rem 0;
    }
    .stat-card {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0.5rem;
        text-align: center;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #FF8C00;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .org-image {
        width: 100%;
        max-width: 800px;
        margin: 2rem auto;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .text-list-item {
        background-color: #f8f9fa;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 5px solid #FF8C00;
    }
    .organigramme-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 0;
    }
    .president-card {
        text-align: center;
        max-width: 400px;
        margin: 0 auto 3rem;
        position: relative;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 2px solid #FF8C00;
    }
    .president-card .member-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 3px solid #FF8C00;
    }
    .president-card .member-name {
        font-size: 2rem;
        font-weight: 700;
        color: #FF8C00;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .president-card .member-title {
        font-size: 1.2rem;
        color: #333;
        font-weight: 600;
        background: #FF8C00;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        display: inline-block;
    }
    .member-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding: 2rem;
    }
    .member-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    .member-image {
        width: 100%;
        height: 220px;
        object-fit: contain;
        background-color: #f8f9fa;
    }
    .member-info {
        padding: 1.5rem;
    }
    .member-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .member-title {
        font-size: 0.9rem;
        color: #FF8C00;
        font-weight: 500;
    }
    .hierarchy-line {
        width: 100%;
        height: 2px;
        background-color: #FF8C00;
        margin: 2rem 0;
        position: relative;
    }
    .hierarchy-line::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        background-color: #FF8C00;
        border-radius: 50%;
    }
    .member-group {
        margin-bottom: 3rem;
    }
    .group-title {
        color: #FF8C00;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
        padding-bottom: 1rem;
    }
    .group-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: #FF8C00;
    }
</style>
@endpush

@section('content')
<main class="container-fluid px-4 py-8">
    <h1 class="text-3xl font-bold text-primary mb-6 text-center">Organisation du RHDP</h1>

    <div class="organigramme-container">
        <!-- Président -->
        @php
            $president = \App\Models\OrganizationStructure::where('role', 'president')
                ->where('group', 'directoire')
                ->where('is_active', true)
                ->first();
        @endphp
        @if($president)
        <div class="president-card member-card">
            <a href="{{ route('president.presentation') }}" class="text-decoration-none">
                <img src="{{ $president->image_url }}" alt="{{ $president->name }}" class="member-image">
                <div class="member-info">
                    <div class="member-name">{{ $president->name }}</div>
                    <div class="member-title">{{ $president->title }}</div>
                </div>
            </a>
        </div>
        @endif

        <!-- Direction -->
        @php
            $directoireMembers = \App\Models\OrganizationStructure::where('group', 'directoire')
                ->where('role', '!=', 'president')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        @endphp
        @if($directoireMembers->isNotEmpty())
        <div class="member-group">
            <h2 class="group-title">Le Directoire</h2>
            <div class="member-grid">
                @foreach($directoireMembers as $member)
                <div class="member-card">
                    <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="member-image">
                    <div class="member-info">
                        <div class="member-name">{{ $member->name }}</div>
                        <div class="member-title">{{ $member->title }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Secrétaires Exécutifs Adjoints -->
        @php
            $secretariatMembers = \App\Models\OrganizationStructure::where('group', 'secretariat_executif')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        @endphp
        @if($secretariatMembers->isNotEmpty())
        <div class="member-group mt-8">
            <h2 class="group-title">Secrétaires Exécutifs Adjoints</h2>
            <div class="member-grid">
                @foreach($secretariatMembers as $member)
                <div class="member-card">
                    <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="member-image">
                    <div class="member-info">
                        <div class="member-name">{{ $member->name }}</div>
                        <div class="member-title">{{ $member->title }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Départements -->
        @php
            $departments = \App\Models\OrganizationStructure::where('role', 'département')
                ->where('is_active', true)
                ->orderBy('group')
                ->orderBy('order')
                ->get()
                ->groupBy('group');
        @endphp
        @foreach($departments as $group => $groupMembers)
        <div class="member-group mt-8">
            <h2 class="group-title">{{ ucfirst($group) }}</h2>
            <div class="member-grid">
                @foreach($groupMembers as $department)
                <div class="member-card">
                    <div class="member-info">
                        <div class="member-name">{{ $department->name }}</div>
                        <div class="member-title">{{ $department->title }}</div>
                        @if($department->description)
                            <p class="text-sm text-gray-600 mt-2">{{ $department->description }}</p>
                        @endif
                    </div>
                    @if($department->members->isNotEmpty())
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-semibold mb-2">Membres :</h4>
                            <ul class="list-disc pl-4">
                                @foreach($department->members as $member)
                                    <li class="text-sm">{{ $member->name }} - {{ $member->position }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Services -->
        @php
            $services = \App\Models\OrganizationStructure::where('role', 'service')
                ->where('is_active', true)
                ->orderBy('group')
                ->orderBy('order')
                ->get()
                ->groupBy('group');
        @endphp
        @foreach($services as $group => $groupMembers)
        <div class="member-group mt-8">
            <h2 class="group-title">Services {{ ucfirst($group) }}</h2>
            <div class="member-grid">
                @foreach($groupMembers as $service)
                <div class="member-card">
                    <div class="member-info">
                        <div class="member-name">{{ $service->name }}</div>
                        <div class="member-title">{{ $service->title }}</div>
                        @if($service->description)
                            <p class="text-sm text-gray-600 mt-2">{{ $service->description }}</p>
                        @endif
                    </div>
                    @if($service->members->isNotEmpty())
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-semibold mb-2">Membres :</h4>
                            <ul class="list-disc pl-4">
                                @foreach($service->members as $member)
                                    <li class="text-sm">{{ $member->name }} - {{ $member->position }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    @include('parti._organisation_stats')
</main>
@endsection