<template>
    <h4>日記検索</h4>
    <div class="row mb-2">
        <div class="col-md-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="diary" value="diary" @input="clearDiaries" v-model="diaryType">
                <label class="form-check-label" for="diary">全体日記</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="companydiary" value="companydiary" @input="clearDiaries" v-model="diaryType">
                <label class="form-check-label" for="companydiary">銘柄日記</label>
            </div>
        </div>
    </div>    
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" class="form-control" name="search-text" v-model="keyword"
                 placeholder="キーワードから検索" @keyup.enter="searchDiaries(1)">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4 d-flex justify-content-center">
            <button type="button" class="btn btn-primary btn-width mx-1" @click="searchDiaries(1)">検索</button>
            <button type="button" class="btn btn-secondary btn-width mx-1" @click="clearDiaries">クリア</button>
        </div>
    </div>

    <div v-if="(diaryType === 'diary') && isSearched">
        <h4 class="mt-5">検索結果</h4>
        <span class="my-3">ページ: {{ currentPage }} / {{ lastPage }}</span>
        <table class="table table-striped w-auto">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>日記</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="diary in sortDiaries" :key="diary.date">
                    <td><a :href="'/diary?ymd=' + diary.date">{{diary.date}}</a></td>
                    <td>{{diary.text}}</td>
                </tr>
            </tbody>
        </table>
        <!-- container-class: bootstrap class -->
        <paginate
            v-model="currentPage"
            :page-count="lastPage"
            :click-handler="clickCallback"
            :prev-text="'<'"
            :next-text="'>'"
            :container-class="'pagination'"
            :page-class="'page-item'"
        >
        </paginate>
    </div>
    <div v-else-if="(diaryType === 'companydiary') &&  isSearched">
        <h4 class="mt-5">検索結果</h4>
        <span class="my-3">ページ: {{ currentPage }} / {{ lastPage }}</span>
        <table class="table table-striped w-auto">
            <thead>
                <tr>
                    <th>コード</th>
                    <th>会社名</th>
                    <th>日付</th>
                    <th>日記</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="diary in sortDiaries" :key="diary.date">
                    <td>{{diary.code}}</td>
                    <td>{{diary.name}}</td>
                    <td><a :href="'/companydiary?ymd=' + diary.date + '&code=' + diary.code">{{diary.date}}</a></td>
                    <td>{{diary.text}}</td>
                </tr>
            </tbody>
        </table>
        <!-- container-class: bootstrap class -->
        <paginate
            v-model="currentPage"
            :page-count="lastPage"
            :click-handler="clickCallback"
            :prev-text="'<'"
            :next-text="'>'"
            :container-class="'pagination'"
            :page-class="'page-item'"
        >
        </paginate>
    </div>
    <div v-else>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('SearchDiary mounted.');
        },
        data() {
            return {
                keyword: '',
                diaries: [],
                isSearched: false,
                diaryType: 'diary',
                lastPage: 1,
                currentPage: 1
            }
        },
        methods: {
            searchDiaries(page) {
                this.currentPage = page;
                this.isSearched = true;

                if(this.diaryType === 'diary') {
                    axios.get('/search/diary?page=' + page, { 
                    params: {
                        keyword: this.keyword 
                    }
                    })
                    .then(res => {
                        console.log(res.data);
                        this.lastPage = res.data['last_page'];

                        this.diaries = [];
                        res.data.data.forEach(d => {
                            this.diaries.push({
                                date: d['date'],
                                text: d['text'],
                            });
                        });
                    })
                    .catch(err => {
                        console.log(err);
                    });
                }
                else if(this.diaryType === 'companydiary') {
                    console.log('companydiary');

                    axios.get('/search/companydiary?page=' + page, { 
                    params: {
                        keyword: this.keyword 
                    }
                    })
                    .then(res => {
                        console.log(res.data);
                        this.lastPage = res.data['last_page'];

                        this.diaries = [];
                        res.data.data.forEach(d => {
                            this.diaries.push({
                                code: d['code'],
                                name: d['name'],
                                date: d['date'],
                                text: d['text'],
                            });
                        });
                    })
                    .catch(err => {
                        console.log(err);
                    });
                }

            },
            clearDiaries() {
                this.keyword = '';
                this.diaries = [];
                this.isSearched = false;
                this.diaryType = 'diary';
                this.lastPage = 1;
                this.currentPage = 1;
            },
            clickCallback(num) {
                console.log(num);

                this.searchDiaries(Number(num));
                window.scrollTo({
                    top: 0,
                    left: 0,
                    //behavior: 'smooth'
                });
            }
        },
        computed: {
            sortDiaries() {
                this.diaries.sort((a, b) => {
                    a = a['date'];
                    b = b['date'];
                    // 降順
                    return (a === b ? 0 : a < b ? 1 : -1);

                    // a = a['code'];
                    // b = b['code'];
                    // // 降順
                    // return (a === b ? 0 : a < b ? 1 : -1);
                });

                return this.diaries;
            },
        }
    }
</script>
