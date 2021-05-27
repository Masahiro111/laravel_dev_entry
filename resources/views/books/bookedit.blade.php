<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books  Edit') }}
        </h2>
    </x-slot>

    <x-slot name="slot">

        <div class="py-12">
            <!-- Main flame -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        本の編集
                    </div>
        
                    <!-- バリデーションエラーの表示に使用 -->
                    <div>
                        <x-errors class="mb-4" :errors="$errors" />
                    </div>
        
                    <!-- 本登録フォーム -->
                    <div class="mt-10 sm:mt-0 p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Book Title Info.</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Write book title information.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form action="{{route('book.update')}}" method="POST">
                                    @csrf
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-6 gap-6">

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="first_name"
                                                        class="block text-sm font-medium text-gray-700">本のタイトル</label>
                                                    <input type="text" name="item_name" id="item_name"
                                                        autocomplete="given-name" 
                                                        value="{{$book->item_name}}"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>
        
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="item_amount" class="block text-sm font-medium text-gray-700">金額</label>
                                                    <input type="text" name="item_amount" id="amount"
                                                        autocomplete="10" 
                                                        value="{{$book->item_amount}}"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="item_number"
                                                        class="block text-sm font-medium text-gray-700">数</label>
                                                    <input type="text" name="item_number" id="item_nubmer"
                                                        autocomplete="given-name" 
                                                        value="{{$book->item_number}}" 
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>
        
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="published" class="block text-sm font-medium text-gray-700">公開日</label>
                                                    <input type="date" name="published" id="published"
                                                        autocomplete="family-name" 
                                                        value="{{ $book->published }}"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>

                                                <input type="hidden" name="id" value="{{$book->id}}">
        
                                            </div>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-50 sm:px-6">
                                            <button type="submit"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                &nbsp;Save&nbsp;
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
 
                </div>
            </div>
        </div><!-- / Main flame -->

    </x-slot>
</x-app-layout>
