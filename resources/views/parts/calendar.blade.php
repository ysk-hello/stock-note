<?php
$today = date('Y-m-d');

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    if (isset($_GET['ymd'])) {
        $ym = substr($_GET['ymd'], 0, 7);
    } else {
        $ym = substr($today, 0, 7);
    }
}

$timestamp = strtotime('first day of ' . $ym); // 月の最初の日

$this_month = date('Y-m', $timestamp);
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

$day_count = date('t', $timestamp);
$youbi = date('w', $timestamp);     // 0-6

$weeks = [];  // tr
$week = '';   // td
$week .= str_repeat('<td></td>', $youbi);

for ($day = 1; $day <= $day_count; $day++, $youbi++) {
    $target_date = new DateTime($ym . '-' . $day);

    // 祝日
    $holidays = Yasumi\Yasumi::create('Japan', (int)$target_date->format('Y'), 'ja_JP');

    // 日に応じてclassを追加
    if ($today ==  $target_date->format('Y-m-d')) {
        if ($holidays->isHoliday($target_date)) {
            if (isset($selected_date) && $selected_date == $target_date->format('Y-m-d')) {
                $week .= '<td class="today holiday selected">';
            } else {
                $week .= '<td class="today holiday">';
            }
        } else {
            if (isset($selected_date) && $selected_date == $target_date->format('Y-m-d')) {
                $week .= '<td class="today selected">';
            } else {
                $week .= '<td class="today">';
            }
        }
    } else {
        if ($holidays->isHoliday($target_date)) {
            if (isset($selected_date) && $selected_date == $target_date->format('Y-m-d')) {
                $week .= '<td class="holiday selected">';
            } else {
                $week .= '<td class="holiday">';
            }
        } else {
            if (isset($selected_date) && $selected_date == $target_date->format('Y-m-d')) {
                $week .= '<td class="selected">';
            } else {
                $week .= '<td>';
            }
        }
    }

    $week .= $day . '</td>';

    // 週終わり、または、月終わり
    if ($youbi % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }

        // trで囲む
        $weeks[] = '<tr>' . $week . '</tr>';

        $week = '';
    }
}
?>

<div id="calendar">
  <h5>
    <a href="{{'?ym=' . $prev}}"><i class="fa-solid fa-caret-left"></i></a>
        <span id="current_ym"> <?= $this_month; ?> </span>
    <a href="{{'?ym=' . $next}}"><i class="fa-solid fa-caret-right"></i></a>
  </h5>
  <table class="table table-sm table-bordered" id="calendar_table">
    <tr>
        <th>日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th>土</th>
    </tr>
    <?php
        foreach ($weeks as $week) {
            echo $week;
        }
    ?>
  </table>
</div>