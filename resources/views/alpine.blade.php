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
			<div x-data="AlpineSearch({route: '/api/users'})" x-init="doSearch">
				<input class="form-control my-5 col-1" type="text" placeholder="Cerca utente" x-model="search" @input="doSearch()">
				<template x-if="records.length > 0">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Nome</th>
								<th scope="col">Email</th>
								<th scope="col">Città</th>
								<th scope="col">Tag</th>
							</tr>
						</thead>
						<tbody>
						<template x-for="(user, index) in records" :key="index">
							<tr>
								<td x-text="user.name"></td>
								<td x-text="user.email"></td>
								<td x-text="user.city"></td>
								<td>
									<template x-for="tag in user.tags" :key="tag.name" >
										<span class="inline-block px-2 py-1" x-text="tag.name"></span>
									</template>
								</td>
							</tr>
						</template>
						</tbody>
					</table>
					</template>
					<template x-if="records.length === 0">
						<h1 class="text-danger">Nessun utente trovato</h1>
					</template>
				</ul>
				<template x-if="records.length > 0">
					<ul class="pagination">
						<li class="page-item" :class="{ 'disabled': !hasPrevPage }">
								<a class="page-link" href="#" @click.prevent="prevPage()">Precedente</a>
						</li>
						<template x-for="page in pagesToShow" :key="page">
								<li class="page-item" :class="{ 'active': currentPage === page }">
									<a class="page-link" href="#" x-text="page" @click.prevent="changePage(page)"></a>
								</li>
						</template>
						<li class="page-item" :class="{ 'disabled': !hasNextPage }">
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
		 * Passando l'endpoint come parametro del componente, lo manteniamo generico: puoi usarlo per cercare
		 * utenti, prodotti, categorie...
		 *
         * @param route
         * @return {{}}
        * @constructor
         */
		 window.AlpineSearch = function({route}) {
			return {
				search: '',
				records: [],
				currentPage: 1,
				totalPages: 1,
				pagesToShow: [],

				get hasPrevPage() {
					return this.currentPage > 1
				},

				get hasNextPage() {
					return this.currentPage < this.totalPages
				},

				doSearch() {
					fetch(`${route}?query=${this.search}&page=${this.currentPage}`)
						.then(response => response.json())
						.then(data => {
							this.records = data.data;
							this.totalPages = data.last_page;
							this.calculatePagesToShow();
						})
						.catch(error => {
							console.log(`Errore: ${error}`);
						});
				},

				prevPage() {
					if (this.hasPrevPage) {
						this.currentPage--;
						this.doSearch();
					}
				},

				nextPage() {
					if (this.hasNextPage) {
						this.currentPage++;
						this.doSearch();
					}
				},

				changePage(page) {
					if (page > 0 && page <= this.totalPages) {
						this.currentPage = page;
						this.doSearch();
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
