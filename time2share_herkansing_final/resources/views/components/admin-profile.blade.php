<x-base-layout>
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Admin Dashboard</h2>
        
        <!-- Overzicht van alle gebruikers -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">All Users</h3>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Blocked</th>
                        <th class="border border-gray-300 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gebruikers as $gebruiker)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $gebruiker->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $gebruiker->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $gebruiker->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($gebruiker->blocked)
                                    <span class="text-red-500">Yes</span>
                                @else
                                    <span class="text-green-500">No</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <!-- Actieknop voor blokkeren/deblokkeren -->
                                <form action="{{ route('admin.toggleBlock', $gebruiker->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        {{ $gebruiker->blocked ? 'Deblock' : 'Block' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-base-layout>
