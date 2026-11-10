/* ================= DOM READY ================= */
document.addEventListener('DOMContentLoaded', () => {
	const overlay = document.querySelector('.overlay');
	if (overlay) overlay.addEventListener('click', toggleSidebar);
	populateFormaldata();
	populateAppointments();
	populateDoctors();
	populatePatients();
	populateInventory();
	populateBilling();
	populateOperationRooms();
	populateLaboratories();
	
	
});

/* ================= SIDEBAR ================= */
function toggleSidebar() {
	document.body.classList.toggle('sidebar-open');
}

/* ================= MAIN NAV ================= */
function showContent(id, btn) {
	document.querySelectorAll('.right_content .content')
		.forEach(c => c.classList.remove('active'));

	document.getElementById(id)?.classList.add('active');

	document.querySelectorAll('.nav button')
		.forEach(b => b.classList.remove('active'));

	btn?.classList.add('active');

	if (document.body.classList.contains('sidebar-open')) {
		toggleSidebar();
	}
}

/* ================= GENERIC SUB NAV ================= */
function handleSubTab(sectionId, id, btn) {
	document.querySelectorAll(`#${sectionId} .apt_content`)
		.forEach(c => c.classList.remove('active'));

	document.getElementById(id)?.classList.add('active');

	document.querySelectorAll(`#${sectionId} .apt_btns button`)
		.forEach(b => b.classList.remove('active'));

	btn?.classList.add('active');
}

/* ================= SUB NAV WRAPPERS ================= */
function showAppointmentTab(id, btn) { handleSubTab('appointments', id, btn); }
function showDoctorTab(id, btn) { handleSubTab('doctors', id, btn); }
function showPatientTab(id, btn) { handleSubTab('patients', id, btn); }
function showLabTab(id, btn) { handleSubTab('laboratory', id, btn); }
function showBillingTab(id, btn) { handleSubTab('billing', id, btn); }
function showInventoryTab(id, btn) { handleSubTab('inventory', id, btn); }
function showOTTab(id, btn) { handleSubTab('operation_theatre', id, btn); }

/* ================= SAFE EMPTY HANDLERS ================= */
function addAppointment() {}
function addDoctor() {}
function addPatient() {}
function addLab() {}
function createBilling() {}
function addOTRoom() {}
function addSurgery() {}
function saveSettings() {}
function resetSettings() {}

/* ================= SECURITY ================= */
function escapeHTML(str) {
	return String(str)
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#039;");
}

/* ================= UTIL ================= */
function renderTable(selector, rows) {
	const tbody = document.querySelector(selector);
	if (!tbody) return;

	if (!rows || rows.length === 0) {
		tbody.innerHTML =
			`<tr><td colspan="10" style="text-align:center;">No Records Found</td></tr>`;
		return;
	}

	tbody.innerHTML = rows
		.map(r =>
			`<tr>${r.map(c => `<td>${escapeHTML(c ?? '')}</td>`).join('')}</tr>`
		)
		.join('');
}

/* ================= APPOINTMENTS ================= */
function populateAppointments() {

	fetch('upappointments.php')
		.then(response => response.json())
		.then(data => {

			const appointments = data.appointments || [];

			const todayRows = [];
			const upcomingRows = [];
			const pastRows = [];

			const now = new Date();
			const todayDate = now.toISOString().split('T')[0];

			appointments.forEach(a => {

				if (!a.appointment_date || !a.appointment_time) return;

				// Safe ISO date format
				const aptDateTime = new Date(
					`${a.appointment_date}T${a.appointment_time}`
				);

				const formattedTime = a.appointment_time.substring(0, 5);

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

				// UPCOMING (future)
				if (aptDateTime > now) {
					upcomingRows.push(row);
				}

				// PAST
				if (aptDateTime < now) {
					pastRows.push(row);
				}
			});

			// Sort upcoming by nearest date first
			upcomingRows.sort((a, b) => {
				return new Date(`${a[3]}T${a[4]}`) - new Date(`${b[3]}T${b[4]}`);
			});

			renderTable('#apt_table tbody', todayRows);
			renderTable('#up_apt_table tbody', upcomingRows);
			renderTable('#past_apt_table tbody', pastRows);

		})
		.catch(error => {
			console.error("Error loading appointments:", error);
		});
}

/* ================= DOCTORS ================= */
function populateDoctors() {
	fetch('show_docs.php')
		.then(response => response.json())
		.then(data => {
			const doctors = data.doctors || [];

			const doctorRows = doctors.map(d => [
				d.did,
				d.Doctorname,
				d.specialty,
				d.phone,
				d.email
			]);

			renderTable('#doctors_table tbody', doctorRows);
		})
		.catch(error => {
			console.error("Error loading doctors:", error);
		});
}

/* ================= PATIENTS ================= */
function populatePatients() {
	fetch('show_patients.php')
		.then(response => response.json())
		.then(data => {
			const patients = data.patients || [];

			const patientRows = patients.map(p => [
				p.pid,
				p.patientname,
				p.age,
				p.phone,
				p.email,
				p.patient_address
			]);

			renderTable('#patients_table tbody', patientRows);
		})
		.catch(error => {
			console.error("Error loading patients:", error);
		});
}

/* ================= EMPTY SECTIONS ================= */
function populateInventory() {}
	function populateBilling() {
		console.log("Loading billing...");
		fetch('show_bill.php')
			.then(response => response.json())
			.then(data => {
				console.log(data);
				const bills = data.bills || [];

				const billRows = bills.map(b => [
					b.bill_id,
					b.patient_name,
					b.bill_date,
					b.amount,
					b.tax,
					b.total,
					b.bill_description
				]);

				renderTable('#billing_table tbody', billRows);
			})
			.catch(error => {
				console.error("Error loading billing:", error);
			});
	}
function populateOperationRooms() {
	fetch('show_operation_rooms.php')
		.then(response => response.json())
		.then(data => {
			const rooms = data.rooms || [];

			const roomRows = rooms.map(r => [
				r.room_number,
				r.room_name,
				r.capacity,
				r.equipment
			]);

			renderTable('#ot_table tbody', roomRows);
		})
		.catch(error => {
			console.error("Error loading operation rooms:", error);
		});
}
function populateLaboratories() {
	fetch('show_lab.php')
		.then(response => response.json())
		.then(data => {
			const labs = data.labs || [];

			const labRows = labs.map(m => [
				m.lab_id,
				m.lab_name,
				m.lab_location,
				m.head,
				m.tests_available
			]);

			renderTable('#lab_table tbody', labRows);
		})
		.catch(error => {
			console.error("Error loading laboratories:", error);
		});
}
function populateFormaldata() {
	fetch('main_data.php')
		.then(response => response.json())
		.then(data => {
			console.log("Main Data:", data);

			const mainData = data.main_data;

			document.getElementById("patient_name").innerHTML = mainData.username;
			document.getElementById("doc_name").innerHTML = mainData.username;
			document.getElementById("stat_patients").innerHTML = mainData.total_patients;
			document.getElementById("stat_upcoming").innerHTML = mainData.total_appointments;
			document.getElementById("stat_pres").innerHTML = mainData.total_prescriptions;
			document.getElementById("stat_doc").innerHTML = mainData.total_doctors;
			document.getElementById("stat_earn").innerHTML = mainData.total_earnings;

		})
		.catch(error => {
			console.error("Error loading data:", error);
		});
}



