<div class="top-navbar">

    <div class="nav-brand">
        <img src="{{ asset('images/logo.png') }}" class="nav-logo">
        <span class="hospital-name">Medicure</span>
    </div>

<div class="navbar">

    <div class="menu-toggle" onclick="toggleMenu()">
        ☰
    </div>

    <div class="nav-links" id="navLinks">

        <a href="{{ url('/dashboard') }}"
           class="{{ request()->is('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('patient.list') }}"
           class="{{ request()->is('patientList*') || request()->is('patient*') ? 'active' : '' }}">
            Patients
        </a>

        <a href="{{ route('drug.list') }}"
           class="{{ request()->is('drugList*') || request()->is('drug*') ? 'active' : '' }}">
            Drugs
        </a>

        <a href="{{ route('treatment.list') }}"
           class="{{ request()->is('treatmentList*') || request()->is('treatment*') ? 'active' : '' }}">
            Treatments
        </a>

    </div>

</div>

    <div class="profile-dropdown">

        <div class="nav-user" onclick="toggleDropdown()">

            <img src="{{ session('user.image', asset('images/user.jpg')) }}"
                 class="nav-avatar">

            <span class="nav-username">
                {{ session('user.name', 'Admin') }}
            </span>

        </div>

        <div class="dropdown-menu-custom" id="profileMenu">

            <a href="{{ route('profile') }}">
                <i class="bi bi-person"></i> Profile
            </a>

            <a href="{{ route('overview') }}">
                <i class="bi bi-speedometer2"></i> Overview
            </a>

        </div>

    </div>

</div>
<script>
function toggleDropdown() {
    document.getElementById("profileMenu").classList.toggle("show");
}

document.addEventListener("click", function (e) {
    const menu = document.getElementById("profileMenu");
    const user = document.querySelector(".nav-user");

    if (!menu.contains(e.target) && !user.contains(e.target)) {
        menu.classList.remove("show");
    }
});

    function toggleMenu() {
        const nav = document.getElementById('navLinks');
        nav.classList.toggle('active');
    }
</script>