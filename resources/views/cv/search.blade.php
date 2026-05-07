@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">

        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4 bg-white shadow-sm">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Employer CV Search</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h3 class="mb-1">Search Candidate CVs</h3>
                <p class="text-muted mb-4">
                    Employer access is read-only. Employers can search, filter, sort, and view CVs, but cannot edit them.
                </p>

                <form method="GET" action="{{ route('cv.search') }}">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Keyword</label>
                            <input 
                                type="text" 
                                name="keyword" 
                                class="form-control" 
                                placeholder="Name, summary, description..."
                                value="{{ request('keyword') }}"
                            >
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">CV Category</label>
                            <select name="cv_category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($cvCategories as $category)
                                    <option value="{{ $category->id }}" @selected(request('cv_category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Skills</label>
                            <select name="skill_ids[]" class="form-control" multiple size="4">
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}" 
                                        @selected(in_array($skill->id, (array) request('skill_ids', [])))>
                                        {{ $skill->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Command/Ctrl to select multiple skills.</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Minimum Skill Proficiency</label>
                            <select name="proficiency_level_id" class="form-control">
                                <option value="">Any Level</option>
                                @foreach($proficiencyLevels as $level)
                                    <option value="{{ $level->id }}" @selected(request('proficiency_level_id') == $level->id)>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Country</label>
                            <select name="country_id" class="form-control">
                                <option value="">All Countries</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @selected(request('country_id') == $country->id)>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <select name="city_id" class="form-control">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Degree Level</label>
                            <select name="degree_level_id" class="form-control">
                                <option value="">Any Degree</option>
                                @foreach($degreeLevels as $degree)
                                    <option value="{{ $degree->id }}" @selected(request('degree_level_id') == $degree->id)>
                                        {{ $degree->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-control">
                                <option value="recent" @selected(request('sort') == 'recent')>
                                    Most Recently Updated CV
                                </option>
                                <option value="alphabetical" @selected(request('sort') == 'alphabetical')>
                                    Alphabetical Order
                                </option>
                                <option value="experience_desc" @selected(request('sort') == 'experience_desc')>
                                    Approximate Work Experience Length
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('cv.search') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        @if($cvs->count() > 0)
            @foreach($cvs as $cv)
                <div class="card border-0 shadow mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">

                            <div class="col-md-8">
                                <h4 class="mb-1">{{ $cv->full_name }}</h4>

                                <p class="text-muted mb-2">
                                    {{ $cv->category->name ?? 'No Category' }}
                                </p>

                                <p class="mb-2">
                                    <strong>Email:</strong> {{ $cv->email }} |
                                    <strong>Phone:</strong> {{ $cv->phone_number }}
                                </p>

                                <p class="mb-2">
                                    <strong>Location:</strong>
                                    {{ $cv->district->name ?? '' }}
                                    {{ $cv->city->name ?? '' }},
                                    {{ $cv->country->name ?? '' }}
                                </p>

                                <p class="mb-2">
                                    <strong>Approx. Experience:</strong>
                                    {{ $cv->experience_years ?? 0 }} years
                                </p>

                                <p class="mb-2">
                                    {{ \Illuminate\Support\Str::limit($cv->summary, 150) }}
                                </p>

                                <div>
                                    @foreach($cv->skills as $cvSkill)
                                        <span class="badge bg-primary mb-1">
                                            {{ $cvSkill->skill->name ?? '' }}
                                            - {{ $cvSkill->proficiencyLevel->name ?? '' }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="{{ route('cv.show', $cv->id) }}" class="btn btn-primary">
                                    View CV
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $cvs->links() }}
            </div>
        @else
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <h5>No CVs found.</h5>
                    <p class="text-muted mb-0">Try changing your search filters.</p>
                </div>
            </div>
        @endif

    </div>
</section>
@endsection