<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	</style>
	<title>Laravel</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ asset('style.css') }}">
	<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<div id="App">
	<header>
		{{-- <div class="d-flex align-items-center header">
			<div class="container">
				<h1 class="fw-bold">Alpine.js</h1>
			</div>
		</div> --}}
	</header>
	<main>
		<div x-data="AlpineSearch({route: '/api/users'})">
			<input type="text" x-model="search" @input="getUsers()" placeholder="Cerca utenti...">
			<ul>
				<template x-for="(user,index) in users" :key="index">
					<li>
						<strong x-text="user.nome"></strong> - <span x-text="user.email"></span>
					</li>
				</template>
			</ul>
		</div>
	</main>
</div>

	<script>
		/**
		 * Alpine.js search component
		 *
		 * Questo componente interroga l'API di Laravel all'indirizzo fornito
		 * per ottenere e mostrare i risultati.
		 *
		 * L'API accetta il parametro `query` per filtrare i risultati (proprio come nel componente Livewire)
		 * e ritorna l'elenco degli utenti in formato JSON.
		 *
		 * Questo componente interroga l'API quando la query di ricerca è di almeno 3 caratteri e mostra
		 * la lista dei risultati nello stesso formato già realizzato.
		 *
		 *
         * @param route
         * @return {{}}
        * @constructor
         */
window.AlpineSearch = function({route}) {
    return {
        search: '',
        users: [],
        prove:[
            {
                id:1,
                nome: "asd",
                email: "asdsada@gmail.com"
            },
            {
				id:2,
                nome: "ssssssssssssssssss",
                email: "asdsada@gmail.com"
            },
            {
                id:3,
               	nome: "aaaaaaaaaaaaaaaaasd",
                email: "asdsada@gmail.com"
            },
        ],

        getUsers(){
            fetch(`/api/users?search=${this.search}`)
                .then(response => response.json())
				.then(data => {
					this.users = data.data;
        		})
                .catch(errore => {
                    console.log(`Errore: ${errore}`);
                });
        }
    }
}
	</script>
</div>
</body>
</html>
