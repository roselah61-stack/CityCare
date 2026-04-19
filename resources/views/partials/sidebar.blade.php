<div class="sidebar">

    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="{{ route('patient.list') }}" class="{{ request()->is('patient*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        Patients
    </a>

    <a href="{{ route('categories.index') }}" class="{{ request()->is('category*') ? 'active' : '' }}">
        <i class="bi bi-folder"></i>
        Categories
    </a>

    <a href="{{ route('drug.list') }}" class="{{ request()->is('drug*') ? 'active' : '' }}">
        <i class="bi bi-capsule"></i>
        Drugs
    </a>

    <a href="{{ route('treatment.list') }}" class="{{ request()->is('treatment*') ? 'active' : '' }}">
        <i class="bi bi-heart-pulse"></i>
        Treatments
    </a>

</div>

