<x-app-layout>
    <!-- Navigation -->
    <nav class="bg-black border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-white">Admin Dashboard</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="py-12 bg-zinc-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Add New Product -->
                <div class="transform hover:scale-105 transition-all duration-200">
                    <a href="{{ route('admin.products.create') }}" class="block h-full">
                        <div class="h-full rounded-lg bg-zinc-800 border border-zinc-700 p-6 hover:shadow-lg hover:shadow-zinc-800/50 transition-shadow duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-900 text-green-400 mb-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-white">Add New Product</h3>
                                <p class="mt-2 text-sm text-gray-400">Create a new product listing</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Manage Products -->
                <div class="transform hover:scale-105 transition-all duration-200">
                    <a href="{{ route('admin.products.index') }}" class="block h-full">
                        <div class="h-full rounded-lg bg-zinc-800 border border-zinc-700 p-6 hover:shadow-lg hover:shadow-zinc-800/50 transition-shadow duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-900 text-blue-400 mb-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-white">Manage Products</h3>
                                <p class="mt-2 text-sm text-gray-400">View and edit products</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Go to Homepage -->
                <div class="transform hover:scale-105 transition-all duration-200">
                    <a href="{{ route('shop') }}" class="block h-full">
                        <div class="h-full rounded-lg bg-zinc-800 border border-zinc-700 p-6 hover:shadow-lg hover:shadow-zinc-800/50 transition-shadow duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-pink-900 text-pink-400 mb-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-white">Go to Homepage</h3>
                                <p class="mt-2 text-sm text-gray-400">Visit the main website</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Manage Users -->
                <div class="transform hover:scale-105 transition-all duration-200">
                    <a href="{{ route('admin.users.index') }}" class="block h-full">
                        <div class="h-full rounded-lg bg-zinc-800 border border-zinc-700 p-6 hover:shadow-lg hover:shadow-zinc-800/50 transition-shadow duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-900 text-purple-400 mb-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-white">Manage Users</h3>
                                <p class="mt-2 text-sm text-gray-400">View and manage users</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- View Orders -->
                <div class="transform hover:scale-105 transition-all duration-200">
                    <a href="{{ route('admin.orders.index') }}" class="block h-full">
                        <div class="h-full rounded-lg bg-zinc-800 border border-zinc-700 p-6 hover:shadow-lg hover:shadow-zinc-800/50 transition-shadow duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-yellow-900 text-yellow-400 mb-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-white">View Orders</h3>
                                <p class="mt-2 text-sm text-gray-400">Manage customer orders</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>