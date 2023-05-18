<template>
    <h5>
        <a :href="'?ymd=' + prev()"><i class="fa-solid fa-caret-left"></i></a>
            <span>  {{selectedDate.format('YYYY-MM-DD')}}  </span>
        <a :href="'?ymd=' + next()"><i class="fa-solid fa-caret-right"></i></a>
    </h5>
    <table class="table table-sm table-bordered" id="calendar_table">
        <thead>
            <tr>
                <td>日</td>
                <td>月</td>
                <td>火</td>
                <td>水</td>
                <td>木</td>
                <td>金</td>
                <td>土</td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="week in weeks">
                <!-- https://teratail.com/questions/178689 -->
                <td @click="cellClicked">{{week.sun}}</td>
                <td @click="cellClicked">{{week.mon}}</td>
                <td @click="cellClicked">{{week.tue}}</td>
                <td @click="cellClicked">{{week.wed}}</td>
                <td @click="cellClicked">{{week.thu}}</td>
                <td @click="cellClicked">{{week.fri}}</td>
                <td @click="cellClicked">{{week.sat}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import dayjs from "dayjs";
    dayjs.locale("ja");

    export default {
        mounted() {
            console.log('Calendar mounted.');

            let searchParams = new URLSearchParams(window.location.search);
            this.code = searchParams.get('code');

            if(searchParams.has('ymd')){
                this.selectedDate = dayjs(searchParams.get('ymd'));
            }
            else{
                this.selectedDate = dayjs();
            }
            this.setCalendarLines();
            console.log(this.weeks.length);
        },
        data() {
            return {
                code: '',
                selectedDate: null,
                weeks: []
            }
        },
        //props: ['code', 'ymd'],     // https://vuejs.org/guide/components/props.html
        methods: {
            setCalendarLines() {
                // 初日の曜日を計算
                // https://zenn.dev/akkie1030/articles/javascript-dayjs
                let dayOfWeek = this.selectedDate.startOf('month').format('d');
                console.log(dayOfWeek);

                // 月の日数を計算
                let count = this.selectedDate.endOf('month').format('D');
                console.log(count);

                this.weeks = [];
                let day = 1;
                while(day<=count){
                    let week = {
                        sun: '',
                        mon: '',
                        tue: '',
                        wed: '',
                        thu: '',
                        fri: '',
                        sat: ''
                    };

                    while(dayOfWeek % 7 < 7){
                        switch(dayOfWeek % 7){
                            case 0:
                                week.sun = day;
                                break;
                            case 1:
                                week.mon = day;
                                break;
                            case 2:
                                week.tue = day;
                                break;
                            case 3:
                                week.wed = day;
                                break;
                            case 4:
                                week.thu = day;
                                break;
                            case 5:
                                week.fri = day;
                                break;
                            case 6:
                                week.sat = day;
                                break;
                        }

                        dayOfWeek++;
                        day++;
                        if(dayOfWeek % 7 === 0 || count < day) break;
                    }

                    this.weeks.push(week);
                }
            },
            cellClicked(e) {
                console.log('click');
                let date = e.target.innerText;
                console.log(date);

                if(date){
                    this.selectedDate = this.selectedDate.date(date);
                    console.log(this.selectedDate.format('YYYY-MM-DD'));

                    let uRLSearchParams = new URLSearchParams();
                    uRLSearchParams.append('ymd', this.selectedDate.format('YYYY-MM-DD'));
                    if(this.code) {
                        uRLSearchParams.append('code', this.code);
                    }

                    location.href =  '?' + uRLSearchParams.toString();
                }

            },
            prev() {
                console.log(this.selectedDate.subtract(1, 'M').format('YYYY-MM-DD'));
                return this.selectedDate.subtract(1, 'M').format('YYYY-MM-DD');
            },
            next() {
                return this.selectedDate.add(1, 'M').format('YYYY-MM-DD');
            }
        },
        computed: {
        }
    }
</script>
