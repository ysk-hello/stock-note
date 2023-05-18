<template>
    <h2>{{ ymd }}</h2>
    <h4>{{ code }}</h4>
    <div class="row">
        <div class="col">
            <textarea class="form-control" name="diary" cols="30" rows="10" v-model="diaryText"></textarea>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-info" @click="saveDiary">保存</button>
        </div>
    </div>

    <div class="card my-2" v-for="diary in diaries" :key="diary.date">
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
        mounted() {
            console.log('CompanyDiary mounted.');

            this.getDiary();
            this.getDiaries();
        },
        data() {
            return {
                diaryText: '',
                diaries: []
            }
        },
        props: ['code', 'ymd'],     // https://vuejs.org/guide/components/props.html
        methods: {
            getDiary() {
                axios.get('/companydiary/get', { 
                            params: {
                                company_code: this.code,
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
            getDiaries() {
                axios.get('/companydiary/gets', { 
                            params: {
                                company_code: this.code,
                            }
                        })
                        .then(res =>{
                            res.data.forEach(d => {
                                console.log(d);
                                
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
                console.log(this.code);
                console.log(this.ymd);

                axios.post('/companydiary/save', { company_code: this.code, date: this.ymd, text: this.diaryText })
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
