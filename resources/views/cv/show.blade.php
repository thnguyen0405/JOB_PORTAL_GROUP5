@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="card border-0 shadow">
            <div class="card-body p-5">

                @if($cv->template == 'modern')
                    <div class="border-start border-primary border-5 ps-4 mb-4">
                        <h2>{{ $cv->full_name }}</h2>
                        <p class="text-muted mb-1">{{ $cv->category->name ?? '' }}</p>
                        <p>{{ $cv->email }} | {{ $cv->phone_number }}</p>
                        <p>
                            {{ $cv->street_address }},
                            {{ $cv->district->name ?? '' }},
                            {{ $cv->city->name ?? '' }},
                            {{ $cv->country->name ?? '' }}
                        </p>
                    </div>
                @elseif($cv->template == 'classic')
                    <div class="text-center border-bottom pb-3 mb-4">
                        <h2>{{ $cv->full_name }}</h2>
                        <p>{{ $cv->email }} | {{ $cv->phone_number }}</p>
                        <p>{{ $cv->category->name ?? '' }}</p>
                    </div>
                @else
                    <div class="mb-4">
                        <h2>{{ $cv->full_name }}</h2>
                        <p>{{ $cv->email }} | {{ $cv->phone_number }}</p>
                    </div>
                @endif

                <h4>Summary</h4>
                <p>{{ $cv->summary }}</p>

                <hr>

                <h4>Strongest Skills</h4>
                <ul>
                    @foreach($cv->skills as $skill)
                        <li>
                            {{ $skill->skill->name ?? '' }}
                            - {{ $skill->proficiencyLevel->name ?? '' }}
                        </li>
                    @endforeach
                </ul>

                <hr>

                <h4>Education</h4>
                @foreach($cv->educations as $education)
                    <div class="mb-3">
                        <strong>{{ $education->degreeLevel->name ?? '' }}</strong>
                        in {{ $education->major->name ?? '' }}<br>
                        {{ $education->institution->name ?? '' }}
                        ({{ $education->start_year }} - {{ $education->end_year }})
                        <p>{{ $education->description }}</p>
                    </div>
                @endforeach

                <hr>

                <h4>Work History</h4>
                @foreach($cv->workHistories as $work)
                    <div class="mb-3">
                        <strong>{{ $work->job_title }}</strong>
                        at {{ $work->company_name }}<br>
                        {{ $work->start_year }} -
                        {{ $work->is_present ? 'Present' : $work->end_year }}
                        <p>{{ $work->job_description }}</p>
                    </div>
                @endforeach

                <hr>

                <h4>Certificates</h4>
                @foreach($cv->certificates as $certificate)
                    <div class="mb-3">
                        <strong>{{ $certificate->certificateName->name ?? '' }}</strong><br>
                        {{ $certificate->issuingOrganization->name ?? '' }}
                        - {{ $certificate->year_issued }}
                        <p>{{ $certificate->description }}</p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
@endsection