console.log("Script loaded successfully!");
/* ================= DOM READY ================= */
document.addEventListener('DOMContentLoaded', () => {
	const overlay = document.querySelector('.overlay');
	if (overlay) overlay.addEventListener('click', toggleSidebar);

	// Load appointment data from PHP
	populateAppointments();
	populatePatients();
	populatePrescriptions();
	populateInventory();
	populateSessions();	
	main_data();



	// Keep your other demo sections untouched

});


function toggleSidebar() {
    const sidebar = document.querySelector(".left_content");
    const overlay = document.querySelector(".overlay");

    sidebar.classList.toggle("show");
    overlay.classList.toggle("show");
}

function showContent(id, btn) {
    document.querySelectorAll(".content").forEach(c => c.classList.remove("active"));
    document.querySelectorAll(".left_content button").forEach(b => b.classList.remove("active"));

    const selectedContent = document.getElementById(id);
    selectedContent.classList.add("active");
    btn.classList.add("active");

    // 🔥 Reset first sub tab automatically
    const firstSubTab = selectedContent.querySelector(".apt_btns button");
    const firstSubContent = selectedContent.querySelector(".apt_content");

    if (firstSubTab && firstSubContent) {
        selectedContent.querySelectorAll(".apt_btns button").forEach(b => b.classList.remove("active"));
        selectedContent.querySelectorAll(".apt_content").forEach(c => c.classList.remove("active"));

        firstSubTab.classList.add("active");
        firstSubContent.classList.add("active");
    }

    document.querySelector(".left_content").classList.remove("show");
    document.querySelector(".overlay").classList.remove("show");
}

function showAppointmentTab(id, btn) {
    document.querySelectorAll(".apt_content").forEach(c => c.classList.remove("active"));
    document.querySelectorAll(".apt_btns button").forEach(b => b.classList.remove("active"));

    document.getElementById(id).classList.add("active");
    btn.classList.add("active");
}

function toggleShowPassword() {
    const pass = document.getElementById("new_password");
    pass.type = pass.type === "password" ? "text" : "password";
}

function saveSettings() {
    alert("Settings saved successfully!");
}

function resetSettings() {
    location.reload();
}

document.addEventListener("DOMContentLoaded", function () {
    const firstBtn = document.querySelector(".left_content button");
    showContent("dashboard", firstBtn);
});
function showPrescriptionTab(id, btn) {
    document.querySelectorAll("#prescriptions .apt_content").forEach(section => {
        section.classList.remove("active");
    });

    document.querySelectorAll("#prescriptions .apt_btns button").forEach(button => {
        button.classList.remove("active");
    });

    const target = document.getElementById(id);
    if (target) target.classList.add("active");
    if (btn) btn.classList.add("active");
}
function showInventoryTab(id, btn) {
    document.querySelectorAll("#inventory .apt_content").forEach(section => {
        section.classList.remove("active");
    });

    document.querySelectorAll("#inventory .apt_btns button").forEach(button => {
        button.classList.remove("active");
    });

    const target = document.getElementById(id);
    if (target) target.classList.add("active");
    if (btn) btn.classList.add("active");
}
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

	fetch('doc_up_appointments.php')
		.then(response => response.json())
		.then(data => {

			const appointments = data.appointments || [];

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
					a.patient_name,
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
			renderTable('#up_apt_table tbody', upcomingRows);
			renderTable('#past_apt_table tbody', pastRows);

		})
		.catch(error => {
			console.error("Error loading appointments:", error);
		});
}
function populatePatients() {

	fetch('show_patients.php')
		.then(response => response.json())
		.then(data => {

			const patients = data.patients || [];

			console.log("Patients:", patients);

			const patientRows = patients.map(p => [
				p.pid,
				p.patientname,
				p.age,
				p.phone,
				p.email,
				p.patient_address
			]);

			// RENDER TABLES (INSIDE .then — IMPORTANT)
			renderTable('#patient_table tbody', patientRows);

		})
		.catch(error => {
			console.error("Error loading patients:", error);
			});	
}

function populatePrescriptions() {

	fetch('show_prescription.php')
		.then(response => response.json())
		.then(data => {

			const prescriptions = data.prescriptions || [];

			console.log("Prescriptions:", prescriptions);

			const prescriptionRows = prescriptions.map(p => [
				p.id,
				p.patient_name,
				p.prescription_date,
				p.medication,
				p.dosage,
				p.frequency,
				p.notes
			]);
			// RENDER TABLES (INSIDE .then — IMPORTANT)
			renderTable('#prescription_table tbody', prescriptionRows);

		})
		.catch(error => {
			console.error("Error loading prescriptions:", error);
		});
}
function populateInventory() {

	fetch('show_inventory_request.php')
		.then(response => response.json())
		.then(data => {
			const inventory = data.requests || [];

			console.log("	Inventory:", inventory);

			const inventoryRows = inventory.map(i => [
				i.id,
				i.item_name,
				i.quantity,
				i.priority,
				i.date,	
				i.notes
			]);
			// RENDER TABLES (INSIDE .then — IMPORTANT)
			renderTable('#inventory_table tbody', inventoryRows);

		})
		.catch(error => {
			console.error("Error loading inventory:", error);
		});
}
function populateSessions() {

	fetch('show_tele_sessions.php')
		.then(response => response.json())
		.then(data => {
			const sessions = data.sessions || [];

			console.log("Sessions:", sessions);

			const sessionRows = sessions.map(s => [
				s.id,
				s.patient_name,
				s.session_date,
				s.session_time,
				s.notes,
				s.meeting_link

			]);
			// RENDER TABLES (INSIDE .then — IMPORTANT)
			renderTable('#session_table tbody', sessionRows);

		})
		.catch(error => {
			console.error("Error loading sessions:", error);
		});
}
function main_data() {
	fetch('main_data.php')
		.then(response => response.json())
		.then(data => {
			console.log("Main Data:", data);

			// 🔥 Use data directly (NOT data.main_data)
			document.getElementById("patient_name").innerHTML = data.docname;
			document.getElementById("doc_name").innerHTML = data.docname;
			document.getElementById("stat_patients").innerHTML = data.total_patients;
			document.getElementById("stat_upcoming").innerHTML = data.total_appointments;
			document.getElementById("stat_pres").innerHTML = data.total_prescriptions;
		})
		.catch(error => {
			console.error("Error loading data:", error);
		});
}

