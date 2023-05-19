<template>
    <div class="row my-3">
        <div class="col">
            <h2>{{ ymd }}</h2>
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
</template>

<script>
    export default {
        mounted() {
            console.log('Diary mounted.');
            console.log(this.ymd);

            this.getDiary();
        },
        data() {
            return {
                diaryText: '',
                isEdited: false
            }
        },
        props: ['ymd'],     // https://vuejs.org/guide/components/props.html
        methods: {
            editDiary() {
                this.isEdited = !this.isEdited;
            },
            deleteDiary() {
                axios.get('/diary/delete', { 
                            params: {
                                date: this.ymd
                            }
                        })
                        .then(res =>{
                            console.log(res);
                            this.diaryText = '';
                            this.isEdited = false;
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
                            console.log(res);
                            this.diaryText = res.data['text'];
                        })
                        .catch(err => {
                            console.log(err);
                        });
            },
            saveDiary() {
                axios.post('/diary/save', { date: this.ymd, text: this.diaryText })
                    .then(res =>{
                        console.log(res);
                        this.isEdited = false;
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
        }
    }
</script>
