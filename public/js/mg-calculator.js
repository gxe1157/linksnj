/* If JavaScript is enabled, display content */
document.getElementsByName("mgCalculator")[0].style.display = "block";
document.getElementById("mgNoScript").style.display = "none";

/* Settings */
var $currencySymbol = "$";
var $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

/* Adjustments */
var $inputLabels = document.getElementsByClassName("mg-input-label");
var $inputs = document.getElementsByClassName("mg-calculator-input");
for (var i = 0; i < $inputs.length; i++) {
	$inputs[i].style.paddingLeft = parseInt(window.getComputedStyle($inputs[i]).getPropertyValue('padding-left'), 10) * 1 + $inputLabels[i].offsetWidth;
}

/* Check if the input is a number */
function isNumeric(n) {
	if (!isNaN(n)) {
		return n;
	} else {
		return 0
	}
}

function mgCalculatorCalculate() {
	var amortizationHtml = "";
	var tableRows = "";

	/* Inputs */
	var homeValue = isNumeric(document.mgCalculator.homeValue.value);
	var loanAmount = isNumeric(document.mgCalculator.loanAmount.value);
	var loanTerm = isNumeric(document.mgCalculator.loanTerm.value);
	var interest = isNumeric(document.mgCalculator.interest.value);
	var closingCosts = isNumeric(document.mgCalculator.closingCosts.value);
	var pmi = isNumeric(document.mgCalculator.pmi.value);
	var propertyTax = isNumeric(document.mgCalculator.propertyTax.value);

	/* Outputs */
	var mgTotalPayment = document.getElementById("mgTotalPayment");
	var mgMonthlyPayment = document.getElementById("mgMonthlyPayment");
	var mgTotalInterest = document.getElementById("mgTotalInterest");
	var mgMonthlyPMI = document.getElementById("mgMonthlyPMI");
	var mgTotalPMI = document.getElementById("mgTotalPMI");
	var mgTaxPaid = document.getElementById("mgTaxPaid");
	var mgAmortization = document.getElementById("mgAmortization");
	var mgYearlyTax = document.getElementById("mgYearlyTax");
	var mgAnnualPayment = document.getElementById("mgAnnualPayment");
	var mgLastPayment = document.getElementById("mgLastPayment");

	/* Prepare data */
	var newMortgage = loanAmount;
	var totalPayments = loanTerm * 12;
	var dividedInterest = interest / 12 / totalPayments;
	var monthlyInterest = interest / 12;
	var monthlyInstallment = loanAmount * ((monthlyInterest / 100) / (1 - Math.pow(1 + monthlyInterest / 100, -totalPayments)))
	var monthlyPropertyTax = propertyTax / 12 / 100 * homeValue;
	var monthlyPMI = (loanAmount * pmi) / 12 / 100;
	var yearlyInterest = 0;
	var yearlyPrincipal = 0;
	var monthlyPayment = 0;
	var totalPayment = 0;
	var totalPMI = 0;
	var totalInterest = 0;
	var countPMI = 0;
	var currentInterest = 0;
	var currentPrincipal = 0;
	var currentLTV = 0;
	var currentPMI = 0;
	var currentMonthId = new Date().getMonth();
	// Get current month
	var currentMonth = "";
	var currentYear = new Date().getFullYear();
	// Get current year

	for (var i = 0; i < totalPayments; i++) {
		/* Calculate data */
		currentInterest = newMortgage * monthlyInterest / 100;
		currentPrincipal = monthlyInstallment - currentInterest;
		currentLTV = (newMortgage / loanAmount) * 100;
		totalInterest += currentInterest;
		newMortgage -= currentPrincipal;
		yearlyInterest += currentInterest;
		yearlyPrincipal += currentPrincipal;

		/* Only apply PMI if LTV (Loan To Value) is less than 80 (%) */
		if (currentLTV < 80) {
			currentPMI = 0;
		} else {
			currentPMI = monthlyPMI;
			// sum PMI values
			totalPMI += currentPMI;
			// count PMI payments
			countPMI++;
		}

		monthlyPayment = currentInterest + currentPrincipal + currentPMI + monthlyPropertyTax;
		totalPayment += monthlyPayment;

		/* Increment month id */
		currentMonthId++;

		/* If is last month, jump to first and increment currentYear */
		if (currentMonthId == 12) {
			currentMonthId = 0;
			currentYear++;
		}

		/* Get month name */
		currentMonth = $months[currentMonthId];

		/* If year ended show yearly stats */
		if (currentMonthId == 0) {
			/* Prepare rows for display */
			tableRows += "<tr class=\"mg-yearly-row\">";
			tableRows += "<td>" + (currentYear - 1) + "</td>";
			tableRows += "<td>" + $currencySymbol + Math.round(yearlyInterest) + "</td>";
			tableRows += "<td>" + $currencySymbol + Math.round(yearlyPrincipal) + "</td>";
			tableRows += "<td>" + $currencySymbol + Math.round(newMortgage) + "</td>";
			tableRows += "</tr>";

			/* Reset yearly stats */
			yearlyInterest = 0;
			yearlyPrincipal = 0;
		}

		/* Prepare rows for display */
		tableRows += "<tr>";
		tableRows += "<td>" + currentMonth + " " + currentYear + "</td>";
		tableRows += "<td>" + $currencySymbol + Math.round(currentInterest) + "</td>";
		tableRows += "<td>" + $currencySymbol + Math.round(currentPrincipal) + "</td>";
		tableRows += "<td>" + $currencySymbol + Math.round(newMortgage) + "</td>";
		tableRows += "</tr>";

		/* If is last payment then show last year stats */
		if (i == totalPayments - 1) {
			var yearPrev = i == totalPayments - 1 ? 0 : 1;
			/* Prepare rows for display */
			tableRows += "<tr class=\"mg-yearly-row\">";
			tableRows += "<td>" + (currentYear) + "</td>";
			tableRows += "<td>" + $currencySymbol + Math.round(yearlyInterest) + "</td>";
			tableRows += "<td>" + $currencySymbol + Math.round(yearlyPrincipal) + "</td>";
			tableRows += "<td>" + $currencySymbol + Math.round(newMortgage) + "</td>";
			tableRows += "</tr>";
		}
	};

	totalPayment += closingCosts * homeValue / 100;

	/* Results table head */
	amortizationHtml += "<div class=\"mg-amortization\">";
	amortizationHtml += "<table>";
	amortizationHtml += "<thead>";
	amortizationHtml += "<th>Payment</th>";
	amortizationHtml += "<th>Interest</th>";
	amortizationHtml += "<th>Principal</th>";
	amortizationHtml += "<th>Balance</th>";
	amortizationHtml += "</thead>";
	amortizationHtml += "</table>";

	/* Results table body */
	amortizationHtml += "<div class=\"mg-amortization-body\">"
	amortizationHtml += "<table>";
	amortizationHtml += "<tbody>";
	amortizationHtml += tableRows;
	amortizationHtml += "</tbody>";
	amortizationHtml += "</table>";
	amortizationHtml += "</div>";
	amortizationHtml += "</div>"

	/* Display on page */
	if (mgAmortization != null) mgAmortization.innerHTML = amortizationHtml;
	mgTotalPayment.innerHTML = $currencySymbol + (Math.round(totalPayment)).toFixed(2).replace(".00", "");
	mgMonthlyPMI.innerHTML = $currencySymbol + (Math.round(monthlyPMI * 100) / 100).toFixed(2).replace(".00", "");
	mgMonthlyPayment.innerHTML = $currencySymbol + (Math.round(monthlyPayment * 100) / 100).toFixed(2).replace(".00", "");
	mgTaxPaid.innerHTML = $currencySymbol + (Math.round((monthlyPropertyTax * totalPayments + totalPMI + (closingCosts * homeValue / 100)) * 100) / 100).toFixed(2).replace(".00", "");
	mgTotalInterest.innerHTML = $currencySymbol + (Math.round(totalInterest * 100) / 100).toFixed(2).replace(".00", "");
	mgTotalPMI.innerHTML = $currencySymbol + (Math.round(totalPMI * 100) / 100).toFixed(2).replace(".00", "");
	mgYearlyTax.innerHTML = $currencySymbol + (Math.round(monthlyPropertyTax * 12 * 100) / 100).toFixed(2).replace(".00", "");
	mgAnnualPayment.innerHTML = $currencySymbol + (Math.round((monthlyPayment * 12) * 100) / 100).toFixed(2).replace(".00", "");
	mgLastPayment.innerHTML = (currentMonth + " " + currentYear);	
	
	/* Begin replace dots with commas */
	if (mgAmortization != null) mgAmortization.innerHTML = mgAmortization.innerHTML.replace(".", ",");
	mgTotalPayment.innerHTML = mgTotalPayment.innerHTML.replace(".", ",");
	mgMonthlyPMI.innerHTML = mgMonthlyPMI.innerHTML.replace(".", ",");
	mgMonthlyPayment.innerHTML = mgMonthlyPayment.innerHTML.replace(".", ",");
	mgTaxPaid.innerHTML = mgTaxPaid.innerHTML.replace(".", ",");
	mgTotalPMI.innerHTML = mgTotalPMI.innerHTML.replace(".", ",");
	mgTotalInterest.innerHTML = mgTotalInterest.innerHTML.replace(".", ",");
	mgYearlyTax.innerHTML = mgYearlyTax.innerHTML.replace(".", ",");
	mgAnnualPayment.innerHTML = mgAnnualPayment.innerHTML.replace(".", ",");
	/* End replace dots with commas */
	
	/* Hide errors or messages, if any */
	document.getElementById("mgErrorDisplay").innerHTML = "";
	
	/* Fire up the emailing function */
	if (document.getElementById("mgEmail").value.length > 0) {
		
		sendEmail();
	}

	/* Show the results area */
	document.getElementById("mgResults").style.display = "block";
	document.getElementById("mgPrintButton").style.display = "block";
}

function mgCalculatorReset() {
	/* Reset form's data */
	document.getElementsByName("mgCalculator")[0].reset();
	document.getElementById("mgResults").style.display = "none";
	document.getElementById("mgPrintButton").style.display = "none";
}

function mgPrint() {
	/* Fire up print preview on browser */
	window.print();
}

function sendEmail() {
	/* Prepare params and send a POST request to emailing file */
	var params = "to=" + document.getElementById("mgEmail").value;
	params += "&path=" + $path;
	params += "&content=" + document.getElementById("mgResults").innerHTML;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("mgErrorDisplay").innerHTML = xhttp.responseText;
		}
	};
	xhttp.open("POST", "php/email.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(params);
}
