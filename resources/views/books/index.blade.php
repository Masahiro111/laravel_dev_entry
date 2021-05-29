<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books  Index') }}
        </h2>
    </x-slot>

    <x-slot name="slot">

        @if(session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
        @endif
        <div class="py-12">
            <!-- Main flame -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        本のタイトル
                    </div>

                    {!! $mark_to_html !!}
        
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
                                <form action="{{route('books')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-6 gap-6">

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="first_name"
                                                        class="block text-sm font-medium text-gray-700">本のタイトル</label>
                                                    <input type="text" name="item_name" id="item_name"
                                                        autocomplete="given-name"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>
        
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="item_amount" class="block text-sm font-medium text-gray-700">金額</label>
                                                    <input type="text" name="item_amount" id="amount"
                                                        autocomplete="10"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="item_number"
                                                        class="block text-sm font-medium text-gray-700">数</label>
                                                    <input type="text" name="item_number" id="item_nubmer"
                                                        autocomplete="given-name"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="published" class="block text-sm font-medium text-gray-700">公開日</label>
                                                    <input type="date" name="published" id="published" autocomplete="family-name"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-sm">
                                                </div>
                                                
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="item_img" class="block text-sm font-medium text-gray-700">ファイルのアップロード</label>
                                                    <input type="file" name="item_img" id="item_img">
                                                </div>
        
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
        
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="flex flex-col mb-6">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <x-booklist-table class="mb-4" :books="$books" />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{$books->links()}}
        
                </div>
            </div>
        </div><!-- / Main flame -->

    </x-slot>
</x-app-layout>
