<template>
    <div class="row my-3">
        <div class="col">
            <h2>{{ ymd }}</h2>
            <button type="button" class="btn btn-primary btn-width" v-show="!isEdited" @click="editDiary">編集</button>
            <i class="fa-solid fa-trash fa-lg" v-show="isEdited" @click="clickDelete"></i>
            <message :type="message.type" :text="message.text"></message>
            <div class="popup" v-show="isShow">
                <div class="popup-text">削除しますか？</div>
                <div class="popup-footer">
                    <button type="button" class="btn btn-danger btn-width mx-3" @click="deleteDiary">OK</button>
                    <button type="button" class="btn btn-secondary btn-width mx-3" @click="cancelDelete">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <textarea :class="{'form-control': true, 'not-edit': !isEdited}" name="diary" cols="30" rows="10" v-model="diaryText" :readonly="!isEdited" @input="inputText"></textarea>
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
            {{diary.date}}
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
        mounted() {
            console.log('Diary mounted.');

            this.getDiary();
            this.getDiaries();
        },
        data() {
            return {
                diaryText: '',
                isEdited: false,
                isShow: false,
                message: {
                    type: '',
                    text: ''
                },
                lastPage: 1,
                currentPage: 1,
                diaries: []
            }
        },
        props: ['ymd'],     // https://vuejs.org/guide/components/props.html
        methods: {
            editDiary() {
                this.isEdited = !this.isEdited;

                this.message.type = '';
                this.message.text = ''
            },
            clickDelete() {
                this.isShow = true;
            },
            deleteDiary() {
                this.isShow = false;
                axios.get('/diary/delete', { 
                            params: {
                                date: this.ymd
                            }
                        })
                        .then(res =>{
                            console.log(res);
                            this.diaryText = '';
                            this.isEdited = false;

                            this.message.type = 'success';
                            this.message.text = '削除しました。'
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            getDiary() {
                axios.get('/diary/get', { 
                            params: {
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
            saveDiary() {
                this.isShow = false;
                axios.post('/diary/save', { date: this.ymd, text: this.diaryText })
                    .then(res =>{
                        this.isEdited = false;

                        this.message.type = 'success';
                        this.message.text = '保存しました。'
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
            inputText(){
                console.log(this.diaryText);

                if(this.diaryText && this.diaryText.length > 100){
                    this.message.type = 'danger';
                    this.message.text = '文字数を100文字以内にしてください。';
                }
                else{
                    this.message.type = '';
                    this.message.text = '';
                }
            },
            loadMore() {
                ++this.currentPage;
                this.getDiaries();
            },
            getDiaries() {
                //this.diaries =[];
                axios.get('/diary/gets', { 
                            params: {
                                date: this.ymd,
                                page: this.currentPage
                            }
                        })
                        .then(res =>{
                            this.lastPage = res.data['last_page'];

                            res.data.data.forEach(d => {
                                this.diaries.push({
                                    date: d['date'],
                                    text: d['text']
                                });
                            });
                        })
                        .catch(err => {
                            console.log(err);
                        });
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
