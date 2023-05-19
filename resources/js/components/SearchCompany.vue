<template>
    <div class="row">
        <h4>銘柄検索</h4>
        <div class="col-md-4">
            <input type="text" class="form-control" name="search-text" v-model="keyword"
                 placeholder="銘柄コード、企業名から検索" @keyup.enter="searchCompanies">
        </div>
        <div class="col-md-3 d-flex justify-content-end">
            <button type="button" class="btn btn-primary btn-width mx-1" @click="searchCompanies">検索</button>
            <button type="button" class="btn btn-secondary btn-width mx-1" @click="clearCompanies">クリア</button>
        </div>
    </div>

    <div v-if="isSearched">
        <h4 class="mt-5">検索結果</h4>
        <table class="table table-striped w-auto">
            <thead>
                <tr>
                    <th class="text-center">お気に入り</th>
                    <th>コード</th>
                    <th>会社名</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="company in sortCompanies" :key="company.code">
                    <td class="text-center">
                        <i class="fa-solid fa-star" v-show="company.isFavorite" @click="toggleFavorite(company.code)"></i>
                        <i class="fa-regular fa-star" v-show="!company.isFavorite" @click="toggleFavorite(company.code)"></i>
                    </td>
                    <td>{{company.code}}</td>
                    <td><a :href="'/companydiary?code=' + company.code">{{company.name}}</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('SearchCompany mounted.');
        },
        data() {
            return {
                keyword: '',
                companies: [],
                isSearched: false
            }
        },
        methods: {
            searchCompanies() {
                this.isSearched = true;

                axios.get('/company/search', { 
                    params: {
                        keyword: this.keyword 
                    }
                })
                .then(res => {
                    this.companies = [];
                    res.data.forEach(d => {
                        this.companies.push({
                            code: d['code'],
                            name: d['name'],
                            isFavorite: d['user_id'] !== null
                        });
                    });
                })
                .catch(err => {
                    console.log(err);
                });
            },
            clearCompanies() {
                this.keyword = '';
                this.companies = [];
                this.isSearched = false;
            },
            toggleFavorite(code) {
                this.companies.forEach(c => {
                    if(c.code === code){
                        c.isFavorite = !c.isFavorite;
                        axios.get('/favorite/toggle', { 
                            params: {
                                code: c.code
                            }
                        })
                        .then(res =>{
                            console.log(res);
                        })
                        .catch(err => {
                            console.log(err);
                        });
                    }
                });
            }
        },
        computed: {
            sortCompanies() {
                this.companies.sort((a, b) => {
                    a = a['code'];
                    b = b['code'];
                    return (a === b ? 0 : a > b ? 1 : -1);
                });

                return this.companies;
            },
        }
    }
</script>
