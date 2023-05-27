<template>
    <h4>お気に入り</h4>
    <p class="my-3">お気に入りは、最大50件登録できます。（現在: {{ companies.length }}件）</p>
    <div id="favorite-table">
        <table class="table table-striped w-auto">
            <thead>
                <tr>
                    <th class="text-center">お気に入り</th>
                    <th>コード</th>
                    <th>会社名</th>
                    <th>評価</th>
                    <th>日記</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="company in sortCompanies" :key="company.code">
                    <td class="text-center">
                            <i class="fa-solid fa-star fa-lg" v-show="company.isFavorite" @click="toggleFavorite(company.code)"></i>
                            <i class="fa-regular fa-star fa-lg" v-show="!company.isFavorite" @click="toggleFavorite(company.code)"></i>
                    </td>
                    <td>{{company.code}}</td>
                    <td><a :href="'/companydiary?ymd=' + ymd + '&code=' + company.code">{{company.name}}</a></td>
                    <td><span class="badge" :class="{'bg-danger': company.judgement==='0', 'bg-secondary': company.judgement==='1', 'bg-primary': company.judgement==='2'}">
                        {{ getJudgementStr(company.judgement) }}</span></td>
                    <td class="text-line">{{company.text}}</td>
                </tr>
            </tbody>
        </table>
    </div>
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
                            judgement: d['judgement'],
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
                        axios.get('/favorite/toggle', { 
                            params: {
                                code: c.code
                            }
                        })
                        .then(res =>{
                            console.log(res);
                            if(res.data['state'] === 'upper-limit'){
                                alert('お気に入りに登録できませんでした。登録できるのは最大50件です。');
                                c.isFavorite = false;
                            }
                            else{
                                c.isFavorite = !c.isFavorite;
                                if(res.data['state'] === 'delete'){
                                    // 更新
                                    this.getFavorites();
                                }
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                    }
                });
            },
            getJudgementStr(judge){
                switch(judge){
                    case '0':
                        return '買い';
                    case '1':
                        return '中立';
                    case '2':
                        return '売り';
                    default:
                        return '';
                }
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
