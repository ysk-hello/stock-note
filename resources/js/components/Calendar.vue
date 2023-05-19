<template>
    <h5>
        <a :href="'?ymd=' + prev()"><i class="fa-solid fa-caret-left"></i></a>
            <span>  {{selectedDate.format('YYYY-MM-DD')}}  </span>
        <a :href="'?ymd=' + next()"><i class="fa-solid fa-caret-right"></i></a>
    </h5>
    <table class="table table-sm table-bordered" id="calendar-table">
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
                <td :class="{today: week.sun.today, selected: week.sun.selected}" @click="cellClicked">{{week.sun.date}}</td>
                <td :class="{today: week.mon.today, selected: week.mon.selected}" @click="cellClicked">{{week.mon.date}}</td>
                <td :class="{today: week.tue.today, selected: week.tue.selected}" @click="cellClicked">{{week.tue.date}}</td>
                <td :class="{today: week.wed.today, selected: week.wed.selected}" @click="cellClicked">{{week.wed.date}}</td>
                <td :class="{today: week.thu.today, selected: week.thu.selected}" @click="cellClicked">{{week.thu.date}}</td>
                <td :class="{today: week.fri.today, selected: week.fri.selected}" @click="cellClicked">{{week.fri.date}}</td>
                <td :class="{today: week.sat.today, selected: week.sat.selected}" @click="cellClicked">{{week.sat.date}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import dayjs from "dayjs";
    dayjs.locale("ja");

    export default {
        created() {
            let searchParams = new URLSearchParams(window.location.search);
            this.code = searchParams.get('code');

            if(searchParams.has('ymd')){
                this.selectedDate = dayjs(searchParams.get('ymd'));
            }
            else{
                this.selectedDate = dayjs();
            }
        },
        mounted() {
            console.log('Calendar mounted.');

            this.setCalendarLines();
        },
        data() {
            return {
                code: '',
                selectedDate: null,
                weeks: []
            }
        },
        methods: {
            setCalendarLines() {
                // 初日の曜日を計算
                // https://zenn.dev/akkie1030/articles/javascript-dayjs
                let dayOfWeek = this.selectedDate.startOf('month').format('d');

                // 月の日数を計算
                let count = this.selectedDate.endOf('month').format('D');

                this.weeks = [];
                let day = 1;
                while(day<=count){
                    let week = {
                        sun: {
                            date: '',
                            selected: false,
                            today: false,
                        },
                        mon: {
                            date: '',
                            selected: false,
                            today: false,
                        },
                        tue: {
                            date: '',
                            selected: false,
                            today: false,
                        },
                        wed: {
                            date: '',
                            selected: false,
                            today: false,
                        },
                        thu: {
                            date: '',
                            selected: false,
                            today: false,
                        },
                        fri: {
                            date: '',
                            selected: false,
                            today: false,
                        },
                        sat: {
                            date: '',
                            selected: false,
                            today: false,
                        },
                    };

                    while(dayOfWeek % 7 < 7){
                        switch(dayOfWeek % 7){
                            case 0:
                                week.sun.date = day;
                                week.sun.today = this.isToday(day);
                                week.sun.selected = this.isSelected(day);
                                break;
                            case 1:
                                week.mon.date = day;
                                week.mon.today = this.isToday(day);
                                week.mon.selected = this.isSelected(day);
                                break;
                            case 2:
                                week.tue.date = day;
                                week.tue.today = this.isToday(day);
                                week.tue.selected = this.isSelected(day);
                                break;
                            case 3:
                                week.wed.date = day;
                                week.wed.today = this.isToday(day);
                                week.wed.selected = this.isSelected(day);
                                break;
                            case 4:
                                week.thu.date = day;
                                week.thu.today = this.isToday(day);
                                week.thu.selected = this.isSelected(day);
                                break;
                            case 5:
                                week.fri.date = day;
                                week.fri.today = this.isToday(day);
                                week.fri.selected = this.isSelected(day);
                                break;
                            case 6:
                                week.sat.date = day;
                                week.sat.today = this.isToday(day);
                                week.sat.selected = this.isSelected(day);
                                break;
                        }

                        dayOfWeek++;
                        day++;
                        if(dayOfWeek % 7 === 0 || count < day) break;
                    }

                    this.weeks.push(week);
                }
            },
            isToday(day){
                // 本日
                let today = dayjs().format('YYYY-MM-DD');
                return this.selectedDate.date(day).format('YYYY-MM-DD') === today;
            },
            isSelected(day){
                // 選択日
                let selected = this.selectedDate.format('YYYY-MM-DD');
                return this.selectedDate.date(day).format('YYYY-MM-DD') === selected;
            },
            cellClicked(e) {
                let date = e.target.innerText;

                if(date){
                    this.selectedDate = this.selectedDate.date(date);

                    let uRLSearchParams = new URLSearchParams();
                    uRLSearchParams.append('ymd', this.selectedDate.format('YYYY-MM-DD'));
                    if(this.code) {
                        uRLSearchParams.append('code', this.code);
                    }

                    location.href =  '?' + uRLSearchParams.toString();
                }
            },
            prev() {
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
