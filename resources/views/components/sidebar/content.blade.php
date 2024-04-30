<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>

    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')"
    >
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.dropdown
        title="Manage"
        :active="Str::startsWith(request()->route()->uri(), 'buttons')"
    >
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink
            title="Users"
            href="{{ route('list.user') }}"
            :active="request()->routeIs('list.user')"
        />
        <x-sidebar.sublink
            title="Parameters"
            href="{{ route('table_list.settings') }}"
            :active="request()->routeIs('table_list.settings')"
        />
        <x-sidebar.sublink
            title="Plans"
            href="{{ route('list-plan.plan') }}"
            :active="request()->routeIs('list-plan.plan')"
        />
        <x-sidebar.sublink
            title="Clients"
            href="{{ route('list-client.client') }}"
            :active="request()->routeIs('list-client.client')"
        />
        <x-sidebar.sublink
            title="Business"
            href="{{ route('list-affaire.affaire') }}"
            :active="request()->routeIs('list-affaire.affaire')"
        />
    </x-sidebar.dropdown>

    <div
        x-transition
        x-show="isSidebarOpen || isSidebarHovered"
        class="text-sm text-gray-500"
    >
        Dummy Links
    </div>

    @php
        $links = array_fill(0, 20, '');
    @endphp

    @foreach ($links as $index => $link)
        <x-sidebar.link title=" link {{ $index + 1 }}" href="#" />
    @endforeach

</x-perfect-scrollbar>
