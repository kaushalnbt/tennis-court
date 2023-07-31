<meta name="csrf-token" content="{{ csrf_token() }}" />
<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
              <table class="min-w-full">
                <thead class="border-b">
                  <tr>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                      #
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Customer Name
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Construction of
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Created By
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Created at
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Updated at
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($proposals as $proposal)
                        <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ $proposal->customer_name }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ $proposal->construction_of }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ $proposal->user->name }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ $proposal->created_at }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{ $proposal->updated_at }}
                            </td>
                            <td class="text-sm text-gray-900 font-light px-2 py-1 whitespace-nowrap">
                                <a href="{{ route('proposal.edit',['proposal' => $proposal->id]) }}"><x-button type="button">Edit</x-button></a>
                            </td>
                            <td class="text-sm text-gray-900 font-light px-2 py-1 whitespace-nowrap">
                                <a href="{{ route('proposal.delete',['proposal' => $proposal->id]) }}" onclick="confirmDelete(event)"><x-button type="button">Delete</x-button></a>
                            </td>
                            <td class="text-sm text-red-900 font-light px-2 py-1 whitespace-nowrap">
                                <a href="{{ route('proposal.export',['proposal' => $proposal->id]) }}"><x-button type="button">Export PDF</x-button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <div class="my-3">
                {{ $proposals->links() }}
            </div>
          </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(event) {
        const customerName = "{{$proposal->customer_name}}";
        const confirmation = confirm('Are you sure you want to delete ' + customerName + '?');
        
        if (!confirmation) {
            event.preventDefault();
        }
    }
</script>

