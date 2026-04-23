<div class="top-navbar">

    <div class="nav-brand">
        <img src="{{ asset('images/logo.png') }}" class="nav-logo">
        <span class="hospital-name">CityCare Medical Centre</span>
    </div>

    <div class="profile-dropdown">

        <div class="nav-user" onclick="toggleDropdown()">

            <img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) . '?v=' . auth()->user()->updated_at->timestamp : asset('images/user.jpg') }}"
                 class="nav-avatar"
                 title="{{ auth()->user()->name ?? 'Admin' }}">

        </div>

        <div class="dropdown-menu-custom" id="profileMenu">

            <a href="{{ route('profile') }}">
                <i class="bi bi-person"></i> Profile
            </a>

            <a href="{{ route('overview') }}">
                <i class="bi bi-speedometer2"></i> Overview
            </a>

            <hr class="dropdown-divider my-1">

            <a href="{{ route('logout') }}" class="text-danger">
                <i class="bi bi-box-arrow-right text-danger"></i> Logout
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

    if (menu && user && !menu.contains(e.target) && !user.contains(e.target)) {
        menu.classList.remove("show");
    }
});
</script>