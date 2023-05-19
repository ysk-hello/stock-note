<template>
    <div class="row my-3">
        <div class="col">
            <h2>{{ ymd }}</h2>
            <h4>{{ code }}: <span v-text="name"></span></h4>
            <button type="button" class="btn btn-primary" v-show="!isEdited" @click="editDiary">編集</button>
            <button type="button" class="btn btn-danger" v-show="isEdited" @click="deleteDiary">削除</button>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <textarea :class="{'form-control': true, 'not-edit': !isEdited}" name="diary" cols="30" rows="10" v-model="diaryText" :readonly="!isEdited"></textarea>
        </div>
    </div>
    <div class="row my-3">
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary btn-width mx-3" v-show="isEdited" @click="saveDiary">保存</button>
            <button type="button" class="btn btn-secondary btn-width mx-3" v-show="isEdited" @click="cancel">キャンセル</button>
        </div>
    </div>

    <div class="card my-2" v-for="diary in sortDiaries" :key="diary.date">
        <div class="card-header">
            {{diary.date}}
        </div>
        <div class="card-body">
            <p class="card-text">
                {{diary.text}}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.getName();
        },
        mounted() {
            console.log('CompanyDiary mounted.');

            this.getDiary();
            this.getDiaries();
        },
        data() {
            return {
                name: '',
                diaryText: '',
                diaries: [],
                isEdited: false
            }
        },
        props: ['code', 'ymd'],     // https://vuejs.org/guide/components/props.html
        methods: {
            editDiary() {
                this.isEdited = !this.isEdited;
            },
            deleteDiary() {
                axios.get('/companydiary/delete', { 
                            params: {
                                company_code: this.code,
                                date: this.ymd
                            }
                        })
                        .then(res =>{
                            this.diaryText = '';
                            this.isEdited = false;
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
                            console.log(res.data['name']);
                            this.name = res.data['name'];
                            console.log(this.name);
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
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            getDiaries() {
                this.diaries =[];
                axios.get('/companydiary/gets', { 
                            params: {
                                company_code: this.code,
                            }
                        })
                        .then(res =>{
                            res.data.forEach(d => {
                                this.diaries.push({
                                    date: d['date'],
                                    text: d['text']
                                });
                            });
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            saveDiary() {
                axios.post('/companydiary/save', { company_code: this.code, date: this.ymd, text: this.diaryText })
                    .then(res =>{
                        this.isEdited = false;
                        this.getDiaries();
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            cancel() {
                this.isEdited = false;
            }
        },
        computed: {
            sortDiaries() {
                this.diaries.sort((a, b) => {
                    a = a['date'];
                    b = b['date'];
                    return (a === b ? 0 : a > b ? -1 : 1);
                });

                return this.diaries;
            }
        }
    }
</script>
