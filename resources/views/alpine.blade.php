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
		<div class="d-flex align-items-center header">
			<div class="container">
				<h1 class="fw-bold">Alpine.js</h1>
			</div>
		</div>
	</header>
	<main>
		<div class="container wrapper">	
			<div x-data="AlpineSearch({route: '/api/users'})" x-init="getUsers">
				<input class="form-control my-5 col-1" type="text" placeholder="Cerca utente" x-model="search" @input="getSearchedUser()">
				<template x-if="users.length > 0">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Nome</th>
								<th scope="col">Email</th>
								<th scope="col">Città</th>
								<th scope="col">Tag</th>
							</tr>
						</thead>
					<template x-for="(user, index) in users" :key="index">				
						<tbody>
						<tr>
							<td x-text="user.name"></td>
							<td x-text="user.email"></td>
							<td x-text="user.city"></td>
							<template x-for="(tag,indexTag) in user.tags" :key="indexTag" >
								<td class="d-flex flex-column" x-text="tag.name"></td>
							</template>
						</tr>
						</tbody>
					</table>					
				</template>			
					</template>
					<template x-if="users.length === 0">
						<h1 class="text-danger">Nessun utente trovato</h1>
					</template>
				</ul>
				<template x-if="users.length > 0">
					<ul class="pagination">
						<li class="page-item" :class="{ 'disabled': currentPage === 1 }">
								<a class="page-link" href="#" @click.prevent="prevPage()">Precedente</a>
						</li>
						<template x-for="page in pagesToShow" :key="page">
								<li class="page-item" :class="{ 'active': currentPage === page }">
									<a class="page-link" href="#" x-text="page" @click.prevent="changePage(page)"></a>
								</li>
						</template>
						<li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
							<a class="page-link" href="#" @click.prevent="nextPage()">Successiva</a>
						</li>
					</ul>
				</template>
			</div>
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
        currentPage: 1,
        totalPages: 1, 
        pagesToShow: [],
        getUsers() {
            fetch(`/api/users?query=${this.search}&page=${this.currentPage}`)
                .then(response => response.json())
                .then(data => {
                    this.users = data.data;
                    this.totalPages = data.last_page; 
                    this.calculatePagesToShow();
                })
                .catch(error => {
                    console.log(`Errore: ${error}`);
                });
        },
		getSearchedUser(){
			setTimeout(() => {
				this.getUsers()
			}, 1000);
		},
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.getSearchedUser();
            }
        },  
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.getSearchedUser();
            }
        },
        changePage(page) {
            if (page > 0 && page <= this.totalPages) {
                this.currentPage = page;
                this.getSearchedUser();
            }
        },
        calculatePagesToShow() {
            const maxPagesToShow = 10; 
            const startPage = Math.max(this.currentPage - maxPagesToShow /2 ,1);
            const endPage = Math.min(startPage + maxPagesToShow - 1, this.totalPages);
            this.pagesToShow = Array.from({length: (endPage - startPage + 1)}, (v, k) => startPage + k);
        }
    }
}

	</script>
</div>
</body>
</html>
