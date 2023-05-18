// let calendarTable = document.getElementById("calendar_table");

// if(calendarTable){
//   for(let i = 0; i < calendarTable.rows.length; i++){
//     for(let j = 0; j < calendarTable.rows[i].cells.length; j++){
//       calendarTable.rows[i].cells[j].id = i + "-" + j;
//       calendarTable.rows[i].cells[j].onclick = cellClicked;
//     }
//   }
// }

// function cellClicked(e){
//   let ym = document.getElementById("current_ym");
//   // e.target: HTMLTableCellElement
//   if(e.target.innerText){
//     console.log(ym.innerText.trim() + "-" + e.target.innerText.padStart(2, '0'));
//     location.href = "?ymd=" + ym.innerText.trim() + "-" + e.target.innerText.padStart(2, '0');
//   }
// }
