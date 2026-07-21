<div class="navbar bg-base-100 shadow-sm">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
      </div>
      {{-- <ul
        tabindex="-1"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li><a>Item 1</a></li>
        <li>
          <a>Parent</a>
          <ul class="p-2">
            <li class="color-blue"><a>Submenu 1</a></li>
            <li><a>Submenu 2</a></li>
          </ul>
        </li>
        <li><a>Item 3</a></li>
      </ul> --}}
    </div>
    <a href="{{ route('home') }}" class="btn btn-ghost text-xl">Surveys</a>
  </div>
  {{-- <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a>Item 1</a></li>
      <li>
        <details>
          <summary>Parent</summary>
          <ul class="p-2 bg-base-100 w-40 z-1">
            <li><a>Submenu 1</a></li>
            <li><a>Submenu 2</a></li>
          </ul>
        </details>
      </li>
      <li><a>Item 3</a></li>
    </ul>
  </div> --}}
  <div class="navbar-end flex gap-[15px] mr-[10px]">
    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn bg-purple-600 text-white hover:bg-purple-600/70">Log-out</button>
        </form>

    @endauth

    @guest
        <a href="{{ route('login') }}" class="btn bg-cyan-600 text-white hover:bg-cyan-600/70">Log-in</a>
        <a href="{{ route('register') }}" class="btn">Register</a>
    @endguest

  </div>
</div>
