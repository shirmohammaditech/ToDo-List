<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="flex">
                    <div class="flex-auto text-2xl mb-4">Todos List</div>
                    
                    <div class="flex-auto text-right mt-2">
                        <a href="/todo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add new Todo</a>
                    </div>
                </div>
                <table class="w-full text-md rounded mb-4">
                    <thead>
                    <tr class="border-b">
                        <th class="text-left p-3 px-5">Todo</th>
                        <th class="text-left p-3 px-5">Status</th>
                        <th class="text-left p-3 px-5">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(auth()->user()->todos as $todo)
                        <tr class="border-b hover:bg-orange-100">
                            <td class="p-3 px-5">
                                {{$todo->name}}
                            </td>
                            <td class="p-3 px-5">
                                <select name="status_id" id="status_id" class="form-control bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-200 h-7 py-2 px-3 focus:outline-none focus:bg-white" data-id="{{ $todo->id }}">
                                    <option value="0" @if($todo->status == 0) selected @endif>Created</option>
                                    <option value="1" @if($todo->status == 1) selected @endif>Completed</option>
                                    </select>
                            </td>                            
                            <td class="p-3 px-5">
                                
                                <a href="/todo/{{$todo->id}}" name="edit" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Edit</a>
                                <form action="/todo/{{$todo->id}}" class="inline-block">
                                    <button type="submit" name="delete" formmethod="POST" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                        

                    @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>    
</x-app-layout>

<script type="module">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var status_sel = $("#status_id");
        status_sel.data("prev",status_sel.val());

        $("#status_id").on('change', function() {
            var status_id = $(this).val();
            var todo_id = $(this).data("id");
            if(status_id !== $(this).data("prev")) {
                $.ajax({
                    url: '/todo/update-status/'+todo_id,
                    type: "PUT",
                    dataType: "json",
                    data: {status:status_id},
                    success:function(data) {
                        if(data.code) {
                            alert(data.success);
                        }
                        


                    }
                });            
            }
            $(this).data("prev",$(this).val());
        });        
    });
</script>