@extends('layouts.app')
@section('content')


<div class="min-h-screen flex mb-4 row-signup">
    <div class="w-3/5 h-12 row-right">

        <div class="text-dig">
            <p class="w-full text-base sm:text-lg md:text-xl text-center lg:text-2xl xl:text-5xl">
                Gerer de multiple centre de formation
            </p>
            <div class="text-center mb-4 w-3/5">
                <img src="https://cdn.dribbble.com/users/79571/screenshots/5516891/workflow_4x.png">
            </div>
        </div>
    </div>
    <div class="w-2/5  h-12 row-left">
        <div class="text-singup mb-8">
            <h2 class="">
                Nouvelle Formation
            </h2>
        </div>
        <div class="form-signup-dig">
            <div class="w-full max-w-xs">
                <form class="max-w-md mb-4 form-input">
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                            Intitulé de formation
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full h-12 py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                            id="text" type="text" placeholder="nom de la formation">
                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Code de reférence
                        </label>
                        <input
                            class="shadow appearance-none border border rounded h-12 w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="text" type="text" placeholder="code ref">
                    </div>
                    <div class="mb-6">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            mots de passe
                        </label>
                        <input
                            class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" type="password" placeholder="******">
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            class="bg-blue hover:bg-blue-dark text-white font-bold w-full h-12 py-2 px-4  rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            Sign In
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</div>
@endsection