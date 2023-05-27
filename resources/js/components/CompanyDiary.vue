<template>
    <div class="row my-3">
        <div class="col">
            <h2>{{ code }}: <span v-text="name"></span></h2>
            <div class="mb-3">
                お気に入り: 
                <i class="fa-solid fa-star fa-lg" v-show="isFavorite" @click="toggleFavorite()"></i>
                <i class="fa-regular fa-star fa-lg" v-show="!isFavorite" @click="toggleFavorite()"></i>
            </div>
            <h4>{{ ymd }} <span class="badge" :class="{'bg-danger': judgement==='0', 'bg-secondary': judgement==='1', 'bg-primary': judgement==='2'}" v-show="!isEdited">{{ getJudgementStr(judgement) }}</span></h4>
        </div>
    </div>
    <div class="row mb-3 d-flex align-items-center">
        <div class="col-md-3">
            <button type="button" class="btn btn-primary btn-width" v-show="!isEdited" @click="editDiary">編集</button>
            <i class="fa-solid fa-trash fa-lg" v-show="isEdited" @click="clickDelete"></i>
            <div class="popup" v-show="isShow">
                <div class="popup-text">削除しますか？</div>
                <div class="popup-footer">
                    <button type="button" class="btn btn-danger btn-width mx-3" @click="deleteDiary">OK</button>
                    <button type="button" class="btn btn-secondary btn-width mx-3" @click="cancelDelete">キャンセル</button>
                </div>
            </div>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-3">
            <select class="form-select w-100" v-model="judgement" v-show="isEdited">
                <option value=""></option>
                <option value="0">買い</option>
                <option value="1">中立</option>
                <option value="2">売り</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <textarea :class="{'form-control': true, 'not-edit': !isEdited}" name="diary" cols="30" rows="10" v-model="diaryText" :readonly="!isEdited"></textarea>
        </div>
    </div>
    <div class="row my-3">
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary btn-width mx-3" v-show="isEdited" @click="saveDiary">保存</button>
            <button type="button" class="btn btn-secondary btn-width mx-3" v-show="isEdited" @click="cancelSave">キャンセル</button>
        </div>
    </div>

    <div class="card my-2" v-for="diary in sortDiaries" :key="diary.date">
        <div class="card-header">
            {{diary.date}} <span class="badge" :class="{'bg-danger': diary.judgement==='0', 'bg-secondary': diary.judgement==='1', 'bg-primary': diary.judgement==='2'}">{{getJudgementStr(diary.judgement)}}</span>
        </div>
        <div class="card-body">
            <div class="card-text text-line">
                {{diary.text}}
            </div>
        </div>
    </div>

    <div class="text-center">
        <i class="fa-solid fa-rotate my-3" v-show="currentPage < lastPage" @click="loadMore">もっと見る</i>
    </div>
</template>

<script>
    export default {
        created() {
            this.getName();
            this.checkFavorite();
        },
        mounted() {
            console.log('CompanyDiary mounted.');

            this.getDiary();
            this.getDiaries();
        },
        data() {
            return {
                isFavorite: false,
                name: '',
                diaryText: '',
                diaries: [],
                isEdited: false,
                isShow: false,
                lastPage: 1,
                currentPage: 1,
                judgement: null
            }
        },
        props: ['code', 'ymd'],     // https://vuejs.org/guide/components/props.html
        methods: {
            editDiary() {
                this.isEdited = !this.isEdited;
            },
            clickDelete() {
                this.isShow = true;
            },
            deleteDiary() {
                this.diaries =[];
                this.isShow = false;
                axios.get('/companydiary/delete', { 
                            params: {
                                company_code: this.code,
                                date: this.ymd
                            }
                        })
                        .then(res =>{
                            this.diaryText = '';
                            this.isEdited = false;
                            this.currentPage = 1;
                            this.getDiaries();
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            getName(){
                axios.get('/company/getname', { 
                            params: {
                                code: this.code,
                            }
                        })
                        .then(res =>{
                            this.name = res.data['name'];
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            checkFavorite(){
                axios.get('/favorite/check', { 
                            params: {
                                code: this.code,
                            }
                        })
                        .then(res =>{
                            this.isFavorite = res.data['state'];
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            getDiary() {
                axios.get('/companydiary/get', { 
                            params: {
                                company_code: this.code,
                                date: this.ymd
                            }
                        })
                        .then(res =>{
                            this.diaryText = res.data['text'];
                            this.judgement = res.data['judgement'];
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            getDiaries() {
                //this.diaries =[];
                axios.get('/companydiary/gets', { 
                            params: {
                                company_code: this.code,
                                date: this.ymd,
                                page: this.currentPage
                            }
                        })
                        .then(res =>{
                            this.lastPage = res.data['last_page'];

                            res.data.data.forEach(d => {
                                this.diaries.push({
                                    date: d['date'],
                                    text: d['text'],
                                    judgement: d['judgement']
                                });
                            });
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            saveDiary() {
                this.diaries =[];
                this.isShow = false;
                axios.post('/companydiary/save', { company_code: this.code, date: this.ymd, text: this.diaryText, judgement: this.judgement })
                    .then(res =>{
                        this.isEdited = false;
                        this.currentPage = 1;
                        this.getDiaries();
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            cancelSave() {
                this.isShow = false;
                this.isEdited = false;
            },
            cancelDelete() {
                this.isShow = false;
            },
            loadMore() {
                ++this.currentPage;
                this.getDiaries();
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
            toggleFavorite() {
                axios.get('/favorite/toggle', { 
                        params: {
                            code: this.code,
                        }
                    })
                    .then(res =>{
                        console.log(res);
                        if(res.data['state'] === 'upper-limit'){
                            alert('お気に入りに登録できませんでした。登録できるのは最大50件です。');
                            this.isFavorite = false;
                        }
                        else{
                            this.isFavorite = !this.isFavorite;
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
        },
        computed: {
            sortDiaries() {
                this.diaries.sort((a, b) => {
                    a = a['date'];
                    b = b['date'];
                    return (a === b ? 0 : a > b ? -1 : 1);
                });

                return this.diaries;
            },
        }
    }
</script>
