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
                <td>hogehoge</td>
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
                console.log('get favorites');
                // alert('get favorites');

                axios.get('/favorite/get')
                .then(res => {
                    this.companies = [];
                    res.data.forEach(d => {
                        console.log(d['code']);

                        axios.get('/favorite/check', {
                            params: {
                                code: d['code']
                            }
                        })
                        .then(res2 => {
                            this.companies.push({
                                code: d['code'],
                                name: d['name'],
                                isFavorite: res2.data['state']
                            });
                        })
                        .catch(err2 => {
                            console.log(err2);
                        });
                    });
                })
                .catch(err => {
                    console.log(err);
                });
            },
            toggleFavorite(code) {
                console.log(code);

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
            // getDiary() {
            //     axios.get('/companydiary/get', { 
            //                 params: {
            //                     company_code: this.code,
            //                     date: this.ymd
            //                 }
            //             })
            //             .then(res =>{
            //                 console.log(res);
            //                 this.diaryText = res.data['text'];
            //             })
            //             .catch(err => {
            //                 console.log(err);
            //             });
            // },
        },
        computed: {
            sortCompanies() {
                console.log('sort');

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
