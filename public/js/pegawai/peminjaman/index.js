$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadCalendar();
});

let pastDatesWithData = new Set();


const loadCalendar = () => {

    var calendarEl = document.getElementById('sect-calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'local',
        locale: 'id',
        initialView : 'dayGridMonth',
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'title',
            center: null,
            right: 'prev,next'
            // right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: '/getDataPegawaiPeminjaman',
        eventDisplay: 'none',
        height: 800,
        contentHeight: 780,
        aspectRatio: 3,
        views: {
            dayGridMonth: {
                dayMaxEventRows: 2
            }
        },
        selectable: true,
        eventsSet() { renderDateBadges(calendar); },
        datesSet() { renderDateBadges(calendar); },
        select: function (res) {
            let currentDate = new Date().toJSON().slice(0, 10);


            if(res.startStr < currentDate){
                Swal.fire({
                    title: "Perhatian!",
                    text: "Peminjaman ruangan tidak diperbolehkan untuk tanggal yang sudah lewat!",
                    icon: "warning"
                });
            } else {
                const tanggalLabel = res.start.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                Swal.fire({
                    title: 'Detail Peminjaman',
                    html: `<p class="mb-3">${tanggalLabel}</p>`,
                    icon: 'info',
                    confirmButtonText: '<i class="ti ti-plus me-1"></i> Ajukan Peminjaman',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    showConfirmButton: true
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    const a = document.createElement('a');
                    a.href = '#!';
                    a.setAttribute('data-modal','');
                    a.setAttribute('data-title','Form Peminjaman');
                    a.setAttribute('data-url', `/pegawai-peminjaman/add?tanggal=${res.startStr}`);
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                });
            }

        },
        eventClick: function (res) {
            // console.log(res);

            // showPreviewPeminjaman(res.event._def.publicId);
        },
        dayCellDidMount: function (info) {
            const today = new Date().toLocaleDateString('sv');
            const cellDate = info.date.toLocaleDateString('sv');


            if (cellDate === today) {
                info.el.style.backgroundColor = 'rgba(13,110,253,0.1)';
                info.el.style.borderRadius = '4px';
            }

            const now = new Date();
            now.setHours(0, 0, 0, 0);
            const NowFuture = new Date(info.date);
            NowFuture.setHours(0, 0, 0, 0);

            if (NowFuture >= now) {
                info.el.classList.add('fc-hoverable');
            }



            const formattedDate = info.date.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            let frame = info.el.querySelector('.fc-daygrid-day-frame');
            if (!frame) {
                frame = info.el;
            }

            const cell = new Date(info.date); cell.setHours(0,0,0,0);
            if (cell < now) return;

            const wrap = document.createElement('div');
            wrap.style.position = 'absolute';
            wrap.style.top = '50%';
            wrap.style.left = '50%';
            wrap.style.transform = 'translate(-50%, -50%)';
            wrap.style.display = '';
            wrap.style.flexDirection = 'column';
            wrap.style.alignItems = 'center';
            wrap.style.gap = '1px';
            wrap.style.zIndex = '5';

            frame.appendChild(wrap);
        },
        selectAllow: function(selectInfo) {
            const now = new Date();
            now.setHours(0, 0, 0, 0);
            return selectInfo.start >= now;
        },
        dateClick: function(info) {
            const ds = info.dateStr;
            const today = new Date(); today.setHours(0,0,0,0);
            const clicked = new Date(ds); clicked.setHours(0,0,0,0);

            if (clicked < today && pastDatesWithData.has(ds)) {
               showInfoPeminjaman(ds);
            }
        },

    });
    calendar.render();
}

function renderDateBadges(calendar) {
    document.querySelectorAll('.fc-daygrid-day .fc-badges-wrap').forEach(el => el.remove());
    pastDatesWithData = new Set();

    const statusByDate = {};
    const statusByDateType = {};
    const PRIORITY = s => ({'-1': 3, '0': 2, '1': 1}[String(s)] ?? 0);

    const STATUS_CLASS = {
        '-1': 'bg-danger',
        '0': 'bg-warning',
        '1': 'bg-success',
    };

    const counts = {};
    calendar.getEvents().forEach(ev => {
        const d = (ev.startStr || '').slice(0, 10);
        if (!d) return;

        const tipe = (ev.extendedProps?.tipe_peminjaman || '').toString().toLowerCase();
        if (!counts[d]) counts[d] = { kendaraan: 0, ruangan: 0 };

        if (tipe === 'kendaraan') counts[d].kendaraan++;
        else if (tipe === 'ruangan') counts[d].ruangan++;

        const status = Number(ev.extendedProps?.status ?? 0);
        if (!statusByDateType[d]) statusByDateType[d] = {};
        if (!statusByDateType[d][tipe] || PRIORITY(status) > PRIORITY(statusByDateType[d][tipe])) {
            statusByDateType[d][tipe] = status;
        }
    });


    const ICONS = {
        kendaraan: '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-steering-wheel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M12 14l0 7" /><path d="M10 12l-6.75 -2" /><path d="M14 12l6.75 -2" /></svg>',
        ruangan: '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-door"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 12v.01" /><path d="M3 21h18" /><path d="M6 21v-16a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v16" /></svg>',
    };

    Object.entries(counts).forEach(([dateStr, { kendaraan, ruangan }]) => {
        const cell  = document.querySelector(`.fc-daygrid-day[data-date="${dateStr}"]`);
        const frame = cell?.querySelector('.fc-daygrid-day-frame');
        if (!frame) return;

        if (getComputedStyle(frame).position === 'static') frame.style.position = 'relative';

        const wrap = document.createElement('div');
        wrap.className = 'fc-badges-wrap';
        frame.classList.add('has-badge');

        const makeBadge = (cls, html, title) => {
            const b = document.createElement('span');
            b.className = `badge ${cls} fc-badge-count`;
            b.innerHTML = html;
            if (title) b.title = title;
            return b;
        };


        const sK = statusByDateType[dateStr]?.kendaraan ?? 0;
        const sR = statusByDateType[dateStr]?.ruangan   ?? 0;
        const badgeClsK = STATUS_CLASS[String(sK)];
        const badgeClsR = STATUS_CLASS[String(sR)];



        if (kendaraan > 0) {
            wrap.appendChild(
                makeBadge(
                badgeClsK,
                `${ICONS.kendaraan} Kendaraan`,
                )
            );
        }

        if (ruangan > 0) {
        wrap.appendChild(
            makeBadge(
            badgeClsR,
            `${ICONS.ruangan} Ruangan`,
            )
        );
        }

        frame.appendChild(wrap);

        const today = new Date(); today.setHours(0,0,0,0);
            const d = new Date(dateStr); d.setHours(0,0,0,0);
            if (d < today && (kendaraan + ruangan) > 0) {
            pastDatesWithData.add(dateStr);
            cell.classList.add('past-has-data');
            cell.setAttribute('tabindex','0');
            cell.title = 'Klik untuk melihat peminjaman tanggal ini';
        }
    });
}

const style = document.createElement('style');
style.textContent = `

    .fc-daygrid-day-frame { position: relative; }

    .fc-daygrid-day:hover .hover-buttons{ display: flex; }

    .fc-badges-wrap{
        position: absolute;
        top: calc(50% + var(--badge-offset, 28px));
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        z-index: 4;
        pointer-events: none;
    }

    .fc-badge-count{
        display: inline-block !important;
        font-size: .7rem;
        line-height: 1;
    }


`;
document.head.appendChild(style);

const style2 = document.createElement('style');
style2.textContent = `.fc-daygrid-day.past-has-data{cursor:pointer;}`;
document.head.appendChild(style2);


function esc(s){ return String(s ?? '').replace(/[&<>"']/g, m=>({
  '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
}[m])); }

async function showInfoPeminjaman(ds){

  Swal.fire({title:'Memuat...', allowOutsideClick:false, didOpen:()=>Swal.showLoading()});

  try{

    const res = await $.getJSON('/getDataPegawaiPeminjaman', { tanggal: ds });

    const rows = Array.isArray(res) ? res : (Array.isArray(res?.events) ? res.events : []);


    const items = rows.map((row,idx)=>{
        const jam_mulai = row.start ? new Date(row.start).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}) : '-';
        const jam_selesai = row.end ? new Date(row.end).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}) : '-';
        const tipe = (row.extendedProps.tipe_peminjaman||'').toString().toLowerCase()==='ruangan' ? 'Ruangan' : 'Kendaraan';
        const tipe_peminjaman = (row.extendedProps.tipe_peminjaman||'').toString().toLowerCase()==='ruangan' ? 'Peminjaman Ruangan' : 'Peminjaman Kendaraan';
        const keperluan = row.extendedProps.keperluan ?row.extendedProps.keperluan:'';
        const status = row.status ?row.status:0;

        let badgeColor = 'secondary';
        let badgeText  = 'Tidak Diketahui';
        let badgeIcon  = '❓';

        if (status == 0) {
            badgeColor = 'warning';
            badgeText  = 'Proses';
            badgeIcon  = `<svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                                                <use xlink:href="#reload"></use>
                                            </svg>`;
        } else if (status == 1) {
            badgeColor = 'success';
            badgeText  = 'Diterima';
            badgeIcon  = `<svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                                                <use xlink:href="#check"></use>
                                            </svg>`;
        } else if (status == -1) {
            badgeColor = 'danger';
            badgeText  = 'Ditolak';
            badgeIcon  = `<svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                                                <use xlink:href="#x"></use>
                                            </svg>`;
        }

        return `
            <div style="border:1px solid #eee;border-radius:10px;padding:.5rem .75rem;margin:.4rem 0;position:relative;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="opacity:.7">${esc(tipe_peminjaman)}</span>
                <span class="badge bg-${badgeColor}" style="font-size:0.8rem;">
                ${badgeIcon} ${badgeText}
                </span>
            </div>
            <div><b>Jam Mulai</b> : ${esc(jam_mulai)}</div>
            <div><b>Jam Selesai</b> : ${esc(jam_selesai)}</div>
            ${row.peminjam ? `<div><b>Peminjam</b> : ${esc(row.peminjam)}</div>` : ''}
            ${row.extendedProps.no_plat ? `<div><b>Kendaraan</b> : ${esc(row.extendedProps.no_plat)}</div>` : ''}
            ${row.extendedProps.driver ? `<div><b>Driver</b> : ${esc(row.extendedProps.driver)}</div>` : ''}
            ${row.extendedProps.nama_ruangan ? `<div><b>Ruangan</b> : ${esc(row.extendedProps.nama_ruangan)}</div>` : ''}
            <div style="height:100px;"><b>Keperluan</b> : ${esc(keperluan)}</div>
            </div>
        `;

    }).join('');

    const tanggalFormatted = new Date(ds).toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    Swal.fire({
      icon: rows.length ? 'info' : 'warning',
      title: `Peminjaman <br> ${tanggalFormatted}`,
      html: rows.length
        ? `<div style="text-align:left">${items}</div>`
        : 'Tidak ada data peminjaman.',
      confirmButtonText: 'Tutup'
    });

  }catch(err){
    Swal.fire({
      icon:'error',
      title:'Gagal memuat',
      text: 'Coba lagi atau hubungi admin.'
    });
    console.error(err);
  }
}



