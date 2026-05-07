<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
        @if (!empty(Auth::user()->image))
            <img src="{{ asset('profile_pic/' . Auth::user()->image) }}" alt=""
                class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
        @else
            <img src="{{ asset('assets/images/avatar7.png') }}" alt=""
                class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
        @endif

        <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>

        <p class="text-muted mb-1 fs-6">
            {{ Auth::user()->designation ?? ucfirst(Auth::user()->role) }}
        </p>

        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">
                Change Profile Picture
            </button>
        </div>
    </div>
</div>

<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">

            {{-- Account Settings: all logged-in users --}}
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('account.profile') }}"
                   class="{{ request()->routeIs('account.profile') ? 'text-primary fw-bold' : '' }}">
                    Account Settings
                </a>
            </li>

            {{-- Job Seeker / Candidate only --}}
            @if(Auth::user()->role == 'user')
                <li class="list-group-item d-flex justify-content-between p-3">
                    <a href="{{ route('cv.edit') }}"
                       class="{{ request()->routeIs('cv.edit') ? 'text-primary fw-bold' : '' }}">
                        My CV
                    </a>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('account.myJobApplications') }}"
                       class="{{ request()->routeIs('account.myJobApplications') ? 'text-primary fw-bold' : '' }}">
                        Jobs Applied
                    </a>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('account.savedJobs') }}"
                       class="{{ request()->routeIs('account.savedJobs') ? 'text-primary fw-bold' : '' }}">
                        Saved Jobs
                    </a>
                </li>
            @endif

            {{-- Employer and Admin only --}}
            @if(in_array(Auth::user()->role, ['employer', 'admin']))
                <li class="list-group-item d-flex justify-content-between p-3">
                    <a href="{{ route('cv.search') }}"
                       class="{{ request()->routeIs('cv.search') ? 'text-primary fw-bold' : '' }}">
                        Search CVs
                    </a>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('account.createJob') }}"
                       class="{{ request()->routeIs('account.createJob') ? 'text-primary fw-bold' : '' }}">
                        Post a Job
                    </a>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('account.myJobs') }}"
                       class="{{ request()->routeIs('account.myJobs') ? 'text-primary fw-bold' : '' }}">
                        My Jobs
                    </a>
                </li>
            @endif

            {{-- Common actions --}}
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.changePassword') }}"
                   class="{{ request()->routeIs('account.changePassword') ? 'text-primary fw-bold' : '' }}">
                    Change Password
                </a>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.logout') }}">
                    Logout
                </a>
            </li>

        </ul>
    </div>
</div>