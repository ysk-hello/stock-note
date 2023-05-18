<template>
    <div class="row">
        <div class="col">
            <textarea class="form-control" name="diary" cols="30" rows="10" v-model="diaryText"></textarea>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary" @click="saveDiary">保存</button>
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
                diaryText: ''
            }
        },
        props: ['ymd'],     // https://vuejs.org/guide/components/props.html
        methods: {
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
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        },
        computed: {
        }
    }
</script>
