console.log("Script loaded successfully!");
/* ================= DOM READY ================= */
document.addEventListener('DOMContentLoaded', () => {
	const overlay = document.querySelector('.overlay');
	if (overlay) overlay.addEventListener('click', toggleSidebar);

	// Load appointment data from PHP
	populateAppointments();
	populatePrescriptions();
	populateBill();
	populateTelemedicine();
	main_data();


	// Keep your other demo sections untouched

});

function showContent(id, btn) {
    document.querySelectorAll('.content').forEach(c =>
        c.classList.remove('active')
    );

    document.querySelectorAll('.left_content button').forEach(b =>
        b.classList.remove('active')
    );

    document.getElementById(id)?.classList.add('active');
    btn?.classList.add('active');

    // ✅ When appointments opens, auto-show upcoming
    if (id === "appointments") {
    const firstAptBtn = document.querySelector(".apt_btns button");
    showAppointmentTab("up_comming_apt", firstAptBtn);
}

}

function showAppointmentTab(id, btn) {
    document.querySelectorAll('.apt_content').forEach(c =>
        c.classList.remove('active')
    );

    document.querySelectorAll('.apt_btns button').forEach(b =>
        b.classList.remove('active')
    );

    document.getElementById(id)?.classList.add('active');
    btn?.classList.add('active');
    
}


// Load dashboard by default
document.addEventListener("DOMContentLoaded", () => {
    showContent("dashboard", document.querySelector(".left_content button"));
});

//appointment table in dashboard

function showTelemedicineTab(id, btn) {
    document.querySelectorAll("#telemedicine .apt_content").forEach(section => {
        section.classList.remove("active");
    });

    document.querySelectorAll("#telemedicine .apt_btns button").forEach(button => {
        button.classList.remove("active");
    });

    const target = document.getElementById(id);
    if (target) target.classList.add("active");
    if (btn) btn.classList.add("active");
}
function renderTable(selector, rows) {
	const tbody = document.querySelector(selector);
	if (!tbody) return;

	if (!rows || rows.length === 0) {
		tbody.innerHTML =
			`<tr><td colspan="10" style="text-align:center;">No Records Found</td></tr>`;
		return;
	}

	tbody.innerHTML = rows
		.map(r => `<tr>${r.map(c => `<td>${c ?? ''}</td>`).join('')}</tr>`)
		.join('');
}

function populateAppointments() {

	fetch('patient_up_appointments.php')
		.then(response => response.json())
		.then(data => {

			const appointments = data.appointments || [];

			console.log("Appointments:", appointments);

			const todayRows = [];
			const upcomingRows = [];
			const pastRows = [];

			const now = new Date();
			const todayDate = now.toISOString().split('T')[0];

			appointments.forEach(a => {

				const aptDateTime = new Date(
					a.appointment_date + " " + a.appointment_time
				);

				const formattedTime = a.appointment_time
					? a.appointment_time.substring(0, 5)
					: '';

				const row = [
					a.appointment_id,
					a.doctor_name,
					a.appointment_date,
					formattedTime,
					a.notes
				];

				// TODAY
				if (a.appointment_date === todayDate) {
					todayRows.push(row);
				}

				// FUTURE
				if (aptDateTime > now) {
					upcomingRows.push(row);
				}

				// PAST
				if (aptDateTime < now) {
					pastRows.push(row);
				}
			});

			// RENDER TABLES (INSIDE .then — IMPORTANT)
            renderTable('#apt_table tbody', todayRows);
			renderTable('#up_apt_table tbody', upcomingRows);
			renderTable('#past_apt_table tbody', pastRows);

		})
		.catch(error => {
			console.error("Error loading appointments:", error);
		});
}

function toggleSidebar(){
    document.querySelector(".left_content").classList.toggle("show");
    document.querySelector(".overlay").classList.toggle("show");
}
function populatePrescriptions() {

	fetch('show_prescription.php')
		.then(response => response.json())
		.then(data => {

			const prescriptions = data.prescriptions || [];

			console.log("Prescriptions:", prescriptions);

			const prescriptionRows = prescriptions.map(p => [
				p.doctor_name,
				p.prescription_date,
				p.medication,
				p.dosage,
				p.frequency,
				p.notes
			]);
			// RENDER TABLES (INSIDE .then — IMPORTANT)
			renderTable('#pres_table tbody', prescriptionRows);

		})
		.catch(error => {
			console.error("Error loading prescriptions:", error);
		});
}
function populateBill(){
    fetch('show_bill.php')
        .then(response => response.json())
        .then(data => {

            const bills = data.bills || [];
            console.log("Bills:", bills);

            const tbody = document.querySelector('#bill_table tbody');
            tbody.innerHTML = ""; // Clear old rows

            bills.forEach(b => {

                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${b.bill_id}</td>
                    <td>${b.bill_date}</td>
                    <td>₹ ${b.amount}</td>
                    <td> ${b.tax}%</td>
                    <td><strong>₹ ${b.total}</strong></td>
                    <td>${b.bill_description}</td>
                `;

                tbody.appendChild(row);
            });

        })
        .catch(error => {
            console.error("Error loading bills:", error);
        });
}
function populateTelemedicine() {

	fetch('show_tele_medicine.php')
		.then(response => response.json())
		.then(data => {

			const teleSessions = data.sessions || [];
			console.log("Telemedicine Sessions:", teleSessions);

			const tbody = document.querySelector('#tele_table tbody');
			tbody.innerHTML = ""; // Clear old rows

			teleSessions.forEach(s => {

				const row = document.createElement("tr");

				row.innerHTML = `
					<td>${s.id}</td>
					<td>${s.doctor_name}</td>
					<td>${s.session_date}</td>
					<td>${s.session_time}</td>
					<td>${s.notes}</td>
					<td>${s.meeting_link}</td>
				`;

				tbody.appendChild(row);
			});

		})
		.catch(error => {
			console.error("Error loading telemedicine sessions:", error);
		});
}	
function main_data() {
	fetch('main_data.php')
		.then(response => response.json())
		.then(data => {
			console.log("Main Data:", data);

			const mainData = data.main_data;

			document.getElementById("patient_name").innerHTML = mainData.username;
			document.getElementById("patient_name_welcome").innerHTML = mainData.username;
		})
		.catch(error => {
			console.error("Error loading data:", error);
		});
}