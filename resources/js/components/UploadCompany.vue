<template>
    <div class="row justify-content-center">
        <div id="side" class="col-md-3">
            <div class="row">
                <div class="col">
                    <input type="file" class="form-control" name="company-file" @change="onCheckUpload">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" @click="uploadFile">アップロード</button>
                </div>
            </div>
        </div>
        <div id="main" class="col-md-9">
            <table class="table">
                <thead>
                    <tr>
                        <th>コード</th>
                        <th>会社名</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="company in companies" :key="company.code">
                        <td>{{company.code}}</td>
                        <td>{{company.name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('UploadCompany mounted.');
            this.showData();
        },
        data() {
            return {
                file: '',
                companies: []
            }
        },
        methods: {
            onCheckUpload(e) {
                console.log('check');
                
                this.file = e.target.files[0];
                console.log(this.file);
            },
            uploadFile() {
                console.log('upload');

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                };

                const formData = new FormData();
                formData.append("file", this.file);

                axios.post('/company/upload', formData, config)
                .then((res) => {
                    console.log(res);
                    alert('finished');

                    this.showData();
                })
                .catch((err) => {
                    console.log(err);
                });
            },
            showData() {
                axios.post('/company/get')
                .then((res) => {
                    console.log(res);

                    res.data.forEach(d => {
                        this.companies.push({
                            code: d['code'],
                            name: d['name']
                        })
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
            }
        }
    }
</script>
