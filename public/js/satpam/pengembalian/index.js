$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    loadCalendar();
});

let pastDatesWithData = new Set();
let datesWithData = new Set();

const loadCalendar = () => {
    var calendarEl = document.getElementById("sect-calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: "local",
        locale: "id",
        initialView: "dayGridMonth",
        themeSystem: "bootstrap",
        headerToolbar: {
            left: "title",
            center: null,
            right: "prev,next",
            // right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: "/getDataSatpamPengembalian",
        eventDisplay: "none",
        height: 800,
        contentHeight: 780,
        aspectRatio: 3,
        views: {
            dayGridMonth: {
                dayMaxEventRows: 2,
            },
        },
        selectable: true,
        eventsSet() {
            renderDateBadges(calendar);
        },
        datesSet() {
            renderDateBadges(calendar);
        },
        select: function (res) {
            const ds = res.startStr;

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const clicked = new Date(ds);
            clicked.setHours(0, 0, 0, 0);

            const hasData = datesWithData.has(ds);

            if (hasData && clicked <= today) {
                // showInfoPengembalian(ds);
            }
        },
        eventClick: function (res) {
            // console.log(res);
            // showPreviewPeminjaman(res.event._def.publicId);
        },
        dayCellDidMount: function (info) {
            const today = new Date().toLocaleDateString("sv");
            const cellDate = info.date.toLocaleDateString("sv");

            if (cellDate === today) {
                info.el.style.backgroundColor = "rgba(13,110,253,0.1)";
                info.el.style.borderRadius = "4px";
            }

            const now = new Date();
            now.setHours(0, 0, 0, 0);
            const NowFuture = new Date(info.date);
            NowFuture.setHours(0, 0, 0, 0);

            if (NowFuture >= now) {
                info.el.classList.add("fc-hoverable");
            }

            let frame = info.el.querySelector(".fc-daygrid-day-frame");
            if (!frame) {
                frame = info.el;
            }
            const cell = new Date(info.date);
            cell.setHours(0, 0, 0, 0);
            if (cell < now) return;
            const wrap = document.createElement("div");
            wrap.style.position = "absolute";
            wrap.style.top = "50%";
            wrap.style.left = "50%";
            wrap.style.transform = "translate(-50%, -50%)";
            wrap.style.display = "";
            wrap.style.flexDirection = "column";
            wrap.style.alignItems = "center";
            wrap.style.gap = "1px";
            wrap.style.zIndex = "5";
            frame.appendChild(wrap);
        },
        selectAllow: function (selectInfo) {
            const now = new Date();
            now.setHours(0, 0, 0, 0);
            return selectInfo.start >= now;
        },
        dateClick: function (info) {
            const ds = info.dateStr;
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const clicked = new Date(ds);
            clicked.setHours(0, 0, 0, 0);

            const hasData = datesWithData.has(ds);
            const isPast = clicked < today;

            if (hasData && clicked <= today) {
                showInfoPengembalian(ds);
            }
        },
    });
    calendar.render();
};

function renderDateBadges(calendar) {
    document
        .querySelectorAll(".fc-daygrid-day .fc-badges-wrap")
        .forEach((el) => el.remove());
    pastDatesWithData = new Set();
    datesWithData = new Set();

    const statusByDate = {};
    const PRIORITY = (s) => ({ "-1": 3, 0: 2, 1: 1 }[String(s)] ?? 0);

    const STATUS_CLASS = {
        "-1": "bg-danger",
        0: "bg-warning",
        1: "bg-success",
    };

    const counts = {};
    calendar.getEvents().forEach((ev) => {
        const d = (ev.startStr || "").slice(0, 10);
        if (!d) return;

        const tipe = (ev.extendedProps?.tipe_peminjaman || "")
            .toString()
            .toLowerCase();
        if (!counts[d]) counts[d] = { kendaraan: 0, ruangan: 0 };

        if (tipe === "kendaraan") counts[d].kendaraan++;
        else if (tipe === "ruangan") counts[d].ruangan++;

        const status = Number(ev.extendedProps?.status ?? 0);
        if (!statusByDate[d] || PRIORITY(status) > PRIORITY(statusByDate[d])) {
            statusByDate[d] = status;
        }
    });

    const ICONS = {
        kendaraan:
            '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-steering-wheel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M12 14l0 7" /><path d="M10 12l-6.75 -2" /><path d="M14 12l6.75 -2" /></svg>',
        ruangan:
            '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-door"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 12v.01" /><path d="M3 21h18" /><path d="M6 21v-16a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v16" /></svg>',
    };

    Object.entries(counts).forEach(([dateStr, { kendaraan, ruangan }]) => {
        const cell = document.querySelector(
            `.fc-daygrid-day[data-date="${dateStr}"]`
        );
        const frame = cell?.querySelector(".fc-daygrid-day-frame");
        if (!frame) return;

        if (getComputedStyle(frame).position === "static")
            frame.style.position = "relative";

        const wrap = document.createElement("div");
        wrap.className = "fc-badges-wrap";
        frame.classList.add("has-badge");

        const makeBadge = (cls, html, title) => {
            const b = document.createElement("span");
            b.className = `badge ${cls} fc-badge-count`;
            b.innerHTML = html;
            if (title) b.title = title;
            return b;
        };

        const badgeCls = STATUS_CLASS[String(statusByDate[dateStr] ?? 0)];

        if (kendaraan > 0) {
            wrap.appendChild(
                makeBadge(
                    "bg-warning",
                    `${ICONS.kendaraan}<span class="badge-label"> Kendaraan</span><sup class="badge-count">${kendaraan}</sup>`
                )
            );
        }

        if (ruangan > 0) {
            wrap.appendChild(
                makeBadge(
                    "bg-primary",
                    `${ICONS.ruangan}<span class="badge-label"> Ruangan</span><sup class="badge-count">${ruangan}</sup>`
                )
            );
        }

        frame.appendChild(wrap);

        if (kendaraan + ruangan > 0) {
            datesWithData.add(dateStr);
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const d = new Date(dateStr);
        d.setHours(0, 0, 0, 0);
        if (kendaraan + ruangan > 0) {
            if (d <= today) {
                pastDatesWithData.add(dateStr);
                cell.classList.add("clickable-has-data");
                cell.setAttribute("tabindex", "0");
                cell.title = "Klik untuk melihat peminjaman tanggal ini";
            }
        }
    });
}

const style = document.createElement("style");
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

    .fc-badge-count .badge-label { margin-left: 4px; }

    .fc-badge-count .badge-count {
    font-size: 10px;
    vertical-align: super;
    margin-left: 2px;
    }

    @media (max-width: 576px) {
    .fc-badge-count .badge-label { display: none; }

    .fc-badge-count { padding: 2px 6px; }
    .fc-badge-count svg { width: 20px; height: 20px; }
    }

`;
document.head.appendChild(style);

const style2 = document.createElement("style");
style2.textContent = `
  /* Hanya sel yg ditandai clickable-has-data yg boleh pointer */
  .fc .fc-daygrid-day.clickable-has-data,
  .fc .fc-daygrid-day.clickable-has-data .fc-daygrid-day-frame {
    cursor: pointer !important;
  }

  /* Kalau ada aturan tema yg pasang pointer-events:none, balikan jadi bisa */
  .fc .fc-daygrid-day.clickable-has-data,
  .fc .fc-daygrid-day.clickable-has-data .fc-daygrid-day-frame {
    pointer-events: auto !important;
  }

  /* Jangan biarkan class tema lain memaksakan not-allowed */
  .fc .fc-daygrid-day.clickable-has-data,
  .fc .fc-daygrid-day.clickable-has-data * {
    cursor: pointer !important;
  }
`;
document.head.appendChild(style2);

function esc(s) {
    return String(s ?? "").replace(
        /[&<>"']/g,
        (m) =>
            ({
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#39;",
            }[m])
    );
}

async function showInfoPengembalian(ds) {
    Swal.fire({
        title: "Memuat...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    try {
        const res = await $.getJSON("/getDataSatpamPengembalian", {
            tanggal: ds,
            type: "get",
        });
        const rows = Array.isArray(res)
            ? res
            : Array.isArray(res?.events)
            ? res.events
            : [];

        const isPastDate = (() => {
            const t = new Date();
            t.setHours(0, 0, 0, 0);
            const d = new Date(ds);
            d.setHours(0, 0, 0, 0);
            return d < t;
        })();

        const ICON_RELOAD = `<svg class="pc-icon" style="width:14px;height:14px;fill:currentColor;"><use xlink:href="#reload"></use></svg>`;
        const ICON_CHECK = `<svg class="pc-icon" style="width:14px;height:14px;fill:currentColor;"><use xlink:href="#check"></use></svg>`;

        const groups = { 0: [], 1: [] };

        rows.forEach((row) => {
            const jam_mulai = row.start
                ? new Date(row.start).toLocaleTimeString("id-ID", {
                      hour: "2-digit",
                      minute: "2-digit",
                  })
                : "-";
            const jam_selesai = row.end
                ? new Date(row.end).toLocaleTimeString("id-ID", {
                      hour: "2-digit",
                      minute: "2-digit",
                  })
                : "-";
            const tipe =
                (row.extendedProps.tipe_peminjaman || "")
                    .toString()
                    .toLowerCase() === "ruangan"
                    ? "Ruangan"
                    : "Kendaraan";
            const tipe_peminjaman =
                tipe === "Ruangan"
                    ? "Peminjaman Ruangan"
                    : "Peminjaman Kendaraan";
            const keperluan = row.extendedProps.keperluan
                ? row.extendedProps.keperluan
                : "";
            const pengembalian_st = row.pengembalian_st
                ? row.pengembalian_st
                : 0;

            const id =
                row.id ||
                row._id ||
                row.publicId ||
                row.extendedProps?.id ||
                row.extendedProps?.peminjaman_id ||
                row.extendedProps?.publicId;
            // const canVerify = !isPastDate && pengembalian_st == 0 && !!id;
            const canVerify = !!id && Number(pengembalian_st) !== 1;

            let badgeColor = "secondary";
            let badgeText = "Tidak Diketahui";
            let badgeIcon = "❓";

            if (pengembalian_st == 0) {
                badgeColor = "warning";
                badgeText = "Belum Dikembalikan";
                badgeIcon = ICON_RELOAD;
            } else if (pengembalian_st == 1) {
                badgeColor = "success";
                badgeText = "Sudah Dikembalikan";
                badgeIcon = ICON_CHECK;
            }

            const cardHTML = `
                    <div class="pinjam-card ${canVerify ? "can-verify" : ""}"
                        data-id="${esc(id)}"
                         data-pengembalian_st="${esc(pengembalian_st)}"
                        style="border:1px solid #eee;border-radius:10px;padding:.5rem .75rem;margin:.4rem 0;position:relative;cursor:${
                            canVerify ? "pointer" : "default"
                        };">
                    <div style="display:flex;justify-content:space-between;align-items:start;">
                        <span style="opacity:.7">${esc(tipe_peminjaman)}</span>
                        <!--<span class="badge bg-${badgeColor}${
                badgeColor === "warning" ? "" : ""
            }" style="font-size:0.8rem;">
                        ${badgeIcon} ${badgeText}${canVerify ? "" : ""}
                        </span> -->
                    </div>
                    <div><b>Jam Mulai</b> : ${esc(jam_mulai)}</div>
                    <div><b>Jam Selesai</b> : ${esc(jam_selesai)}</div>
                    ${
                        row.peminjam
                            ? `<div><b>Peminjam</b> : ${esc(
                                  row.peminjam
                              )}</div>`
                            : ""
                    }
                    ${
                        row.extendedProps.no_plat
                            ? `<div><b>Kendaraan</b> : ${esc(
                                  row.extendedProps.no_plat
                              )}</div>`
                            : ""
                    }
                    ${
                        row.extendedProps.driver
                            ? `<div><b>Driver</b> : ${esc(
                                  row.extendedProps.driver
                              )}</div>`
                            : ""
                    }
                    ${
                        row.extendedProps.nama_ruangan
                            ? `<div><b>Ruangan</b> : ${esc(
                                  row.extendedProps.nama_ruangan
                              )}</div>`
                            : ""
                    }
                    <div style="min-height:60px;"><b>Keperluan</b> : ${esc(
                        keperluan
                    )}</div>
                    ${
                        row.extendedProps.verikator_nm
                            ? `<div><b>Verifkator</b> : ${esc(
                                  row.extendedProps.verikator_nm
                              )}</div>`
                            : ""
                    }
                    ${
                        row.extendedProps.verifikator_tgl
                            ? `<div><b>Tanggal Verifikasi</b> : ${formatTanggalIndonesia(
                                  row.extendedProps.verifikator_tgl
                              )}
                                </div>`
                            : ""
                    }
                    ${
                        row.extendedProps.verifikator_catatan
                            ? `
                                <div style="min-height:60px;"><b>Catatan</b> : ${esc(
                                    row.extendedProps.verifikator_catatan
                                )}</div>
                                <br><br>
                            `
                            : ""
                    }
                    ${
                        row.pengembali
                            ? `<div><b>Penerima Pengembalian</b> : ${esc(
                                  row.pengembali
                              )}</div>`
                            : ""
                    }
                    ${
                        row.extendedProps.pengembalian_tgl
                            ? `<div><b>Tanggal Pengembalian</b> : ${formatTanggalIndonesia(
                                  row.extendedProps.pengembalian_tgl
                              )}
                                </div>`
                            : ""
                    }
                    ${
                        row.extendedProps.pengembalian_catatan
                            ? `
                                <div style="min-height:60px;"><b>Catatan</b> : ${esc(
                                    row.extendedProps.pengembalian_catatan
                                )}</div>
                                <br><br>
                            `
                            : ""
                    }

                    </div>
                `;

            (groups[String(pengembalian_st)] ?? groups["0"]).push(cardHTML);
        });

        const col = (title, cls, icon, listHTML) => `
                <div class="pinjam-col" style="flex:1 1 320px;min-width:260px;">
                    <div class="mb-2">
                    <span class="badge bg-${cls}${
            cls === "warning" ? "" : ""
        } d-inline-flex align-items-start" style="font-size:.75rem;">
                        ${icon} <span style="margin-left:.35rem">${title}</span>
                    </span>
                    </div>
                    ${
                        listHTML && listHTML.trim()
                            ? listHTML
                            : `<div class="text-muted" style="font-size:.85rem;">Tidak ada</div>`
                    }
                </div>
                `;

        const gridHTML = `
                <div id="pinjam-grid"
                    style="display:flex;gap:12px;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;">
                    ${col(
                        "Belum Dikembalikan",
                        "warning",
                        ICON_RELOAD,
                        groups["0"].join("")
                    )}
                    ${col(
                        "Sudah Dikembalikan",
                        "success",
                        ICON_CHECK,
                        groups["1"].join("")
                    )}
                </div>
    `;

        const tanggalFormatted = new Date(ds).toLocaleDateString("id-ID", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        });

        Swal.fire({
            width: 1080,
            icon: rows.length ? "info" : "warning",
            title: `Peminjaman <br> ${tanggalFormatted}`,
            html: rows.length
                ? `<div style="text-align:left; max-height:65vh; overflow-y:auto; padding-right:6px;">${gridHTML}</div>`
                : "Tidak ada data peminjaman.",
            confirmButtonText: "Tutup",
            didOpen: (el) => {
                el.querySelectorAll(".pinjam-card.can-verify[data-id]").forEach(
                    (card) => {
                        const id = card.getAttribute("data-id");
                        if (!id) return;
                        card.addEventListener("click", () => {
                            openVerifikasiPengembalian(id);
                        });
                    }
                );
            },
        });
    } catch (err) {
        Swal.fire({
            icon: "error",
            title: "Gagal memuat",
            text: "Coba lagi atau hubungi admin.",
        });
        console.error(err);
    }
}

async function openVerifikasiPengembalian(id) {
    try {
        Swal.close();
    } catch (e) {}

    Swal.fire({
        title: "Memuat...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });
    let payload = { pengembalian_st: 0, catatan: "" };
    try {
        payload = await $.getJSON(`/satpam-pengembalian/${id}`); // <-- Controller@show
    } catch (e) {
        console.error(e);
        await Swal.fire({
            icon: "error",
            title: "Gagal memuat",
            text: "Tidak bisa mengambil data.",
        });
        return;
    }

    const currentStatus = Number(payload?.pengembalian_st ?? 0);
    const currentNote = payload?.catatan ?? "";

    const html = `
    <div style="text-align:left">
      <div class="mb-2">Pilih Status Pengembalian:</div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="verdict" id="ver_belum" value="0">
        <label class="form-check-label" for="ver_belum">Belum Dikembalikan</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="verdict" id="ver_sudah" value="1">
        <label class="form-check-label" for="ver_sudah">Sudah Dikembalikan</label>
      </div>

      <div class="mt-3">
        <label for="ver_catatan" class="form-label">Catatan (opsional)</label>
        <textarea id="ver_catatan" class="form-control" rows="3" placeholder="Isi alasan/notes jika perlu"></textarea>
      </div>
    </div>
  `;

    Swal.fire({
        title: "Proses Verifikasi",
        html,
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal",
        focusConfirm: false,
        showLoaderOnConfirm: true,
        didOpen: (el) => {
            ({ 0: "#ver_belum", 1: "#ver_sudah" })[String(currentStatus)] ||
                "#ver_belum";
            const sel =
                { 0: "#ver_belum", 1: "#ver_sudah" }[String(currentStatus)] ||
                "#ver_belum";
            el.querySelector(sel).checked = true;
            el.querySelector("#ver_catatan").value = currentNote;
        },
        preConfirm: async () => {
            document
                .getElementById("ver_catatan")
                ?.classList.remove("is-invalid");

            const picked = document.querySelector(
                'input[name="verdict"]:checked'
            );
            if (!picked) {
                Swal.showValidationMessage(
                    "Pilih hasil pengembalian terlebih dahulu."
                );
                return false;
            }
            const pengembalian_st = Number(picked.value);
            const catatan = (
                document.getElementById("ver_catatan")?.value || ""
            ).trim();

            try {
                await $.ajax({
                    url: `/satpam-pengembalian/${id}`,
                    method: "POST",
                    headers: { Accept: "application/json" },
                    dataType: "json",
                    data: { _method: "PUT", pengembalian_st, catatan },
                });
                return { ok: true };
            } catch (xhr) {
                if (xhr.status === 422) {
                    const errs =
                        (xhr.responseJSON && xhr.responseJSON.errors) || {};
                    const msgs = [
                        ...(errs.status || []),
                        ...(errs.catatan || []),
                    ];
                    Swal.showValidationMessage(
                        msgs.join("<br>") || "Data tidak valid."
                    );

                    if (errs.catatan) {
                        document
                            .getElementById("ver_catatan")
                            ?.classList.add("is-invalid");
                    }
                } else {
                    Swal.showValidationMessage("Gagal menyimpan. Coba lagi.");
                }
                return false;
            }
        },

        allowOutsideClick: () => !Swal.isLoading(),
    }).then(async (res) => {
        if (!res.isConfirmed) return;

        try {
            Swal.showLoading();

            await Swal.fire({
                icon: "success",
                title: "Tersimpan",
                timer: 1200,
                showConfirmButton: false,
            });

            if (window._calendar) {
                window._calendar.refetchEvents();
                setTimeout(() => renderDateBadges(window._calendar), 150);
            }
        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: "error",
                title: "Gagal menyimpan",
                text: "Coba lagi atau hubungi admin1.",
            });
        }
    });
}

const styleClickable = document.createElement("style");
styleClickable.textContent = `
  .pinjam-card.can-verify { cursor: pointer !important; }
`;
document.head.appendChild(styleClickable);
