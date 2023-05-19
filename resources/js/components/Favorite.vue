<template>
    <h4>お気に入り</h4>
    <table class="table table-striped w-auto">
        <thead>
            <tr>
                <th class="text-center">お気に入り</th>
                <th>コード</th>
                <th>会社名</th>
                <th>日記</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="company in sortCompanies" :key="company.code">
                <td class="text-center">
                        <i class="fa-solid fa-star" v-show="company.isFavorite" @click="toggleFavorite(company.code)"></i>
                        <i class="fa-regular fa-star" v-show="!company.isFavorite" @click="toggleFavorite(company.code)"></i>
                </td>
                <td>{{company.code}}</td>
                <td><a :href="'/companydiary?ymd=' + ymd + '&code=' + company.code">{{company.name}}</a></td>
                <td>{{company.text}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        mounted() {
            console.log('Favorites mounted.');
            this.getFavorites();
        },
        data() {
            return {
                companies: []
            }
        },
        props: ['ymd'],
        methods: {
            getFavorites() {
                axios.get('/favorite/get',{
                    params: {
                        date: this.ymd
                    }
                })
                .then(res => {
                    // console.log(res);

                    this.companies = [];
                    res.data.forEach(d => {
                        this.companies.push({
                            code: d['code'],
                            name: d['name'],
                            text: d['text'],
                            isFavorite: true
                        });
                    });
                })
                .catch(err => {
                    console.log(err);
                });
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
            },
        },
        computed: {
            sortCompanies() {
                this.companies.sort((a, b) => {
                    a = a['code'];
                    b = b['code'];
                    return (a === b ? 0 : a > b ? 1 : -1);
                });

                return this.companies;
            }
        }
    }
</script>
