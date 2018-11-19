	<link rel="stylesheet"  href="<?= base_url() ?>public/css/mg-light-simplistic.css" />
	<link rel="stylesheet"  href="<?= base_url() ?>public/css/mg-main.css" />

<div>
	<div id="mgNoScript">
		Please enable JavaScript to run this calculator
	</div>
	<form name="mgCalculator" class="mgCalculator">
		<div class="mg-calculator-container js-mg-calculator">
			<div class="mg-calculator-header">
				Mortgage calculator
			</div>
			<div class="mg-calculator-item-container">
				<label> Home value </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Home value/price</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="homeValue" value="100000" class="mg-calculator-input">
					<span class="mg-input-label">$</span>
				</div>
			</div>
			<div class="mg-calculator-item-container">
				<label> Loan amount </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Amount of money to be borrowed</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="loanAmount" value="90000" class="mg-calculator-input">
					<span class="mg-input-label">$</span>
				</div>
			</div>
			<div class="mg-calculator-item-container">
				<label> Loan term </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Loan period</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="loanTerm" value="20" class="mg-calculator-input">
					<span class="mg-input-label">Years</span>
				</div>
			</div>
			<div class="mg-calculator-item-container">
				<label> Interest rate </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Yearly interest percentage</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="interest" value="3.5" class="mg-calculator-input">
					<span class="mg-input-label">%</span>
				</div>
			</div>
			<div class="mg-calculator-item-container">
				<label> Closing costs </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Closing costs percentage</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="closingCosts" value="0" class="mg-calculator-input">
					<span class="mg-input-label">%</span>
				</div>
			</div>
			<div class="mg-calculator-item-container" style="display:none;">
				<label> Private Mortgage Insurance (PMI) </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Private Mortgage Insurance (PMI)</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="pmi" value="0.69" class="mg-calculator-input">
					<span class="mg-input-label">%</span>
				</div>
			</div>
			<div class="mg-calculator-item-container">
				<label> Property tax </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Yearly property tax percentage</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="propertyTax" value="0" class="mg-calculator-input">
					<span class="mg-input-label">%</span>
				</div>
			</div>
			<div class="mg-calculator-item-container">
				<label> Send report by email (optional) </label>
				<div class="mg-tip">
					? <span class="mg-tiptext">Enter your email address if you want the report to be emailed to you. If not, leave the field empty</span>
				</div>
				<div class="mg-calculator-item">
					<input type="text" id="mgEmail" value="" class="mg-calculator-input">
					<span class="mg-input-label"> @ </span>
				</div>
			</div>
			<div class="mg-calculator-item-container mg-buttons">
				<div class="mg-calculator-submit" onclick="mgCalculatorCalculate()">
					Calculate
				</div>
				<div class="mg-calculator-reset" onclick="mgCalculatorReset()">
					Reset
				</div>
			</div>
			<div class="mg-error-display" id="mgErrorDisplay">

			</div>

		</div><!-- end calculator container -->
	</form>

	<!-- Results -->
	<button class="mg-print-button" onclick="mgPrint()" id="mgPrintButton">
		Print
	</button>
	<div class="mg-calculator-results" id="mgResults">
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgTotalPayment">
				-
			</div><label> Total payment </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Total payment, including property tax, closing costs and PMI</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgAnnualPayment">
				-
			</div><label> Annual payment amount </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Annual payment amount, excluding property tax, closing costs and PMI</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgMonthlyPayment">
				-
			</div><label> Monthly payment </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Monthly payment with property tax included</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgTotalInterest">
				-
			</div><label> Total interest </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Total interest paid</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgYearlyTax">
				-
			</div><label> Yearly property tax paid </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Yearly property tax paid</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgTotalPMI">
				-
			</div><label> Total PMI </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Total Private Mortgage Insurance paid</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgMonthlyPMI">
				-
			</div><label> Monthly PMI </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Monthly Private Mortgage Insurance paid</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgTaxPaid">
				-
			</div><label> Total tax paid </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">Private Mortgage Insurance (PMI) + Closing costs + Property tax</span>
			</div>
		</div>
		<div class="mg-calculator-item-container">
			<div class="mg-calculator-item mg-calculator-value" id="mgLastPayment">
				-
			</div><label> Last payment date </label>
			<div class="mg-tip">
				? <span class="mg-tiptext">The date of the last payment</span>
			</div>
		</div>

		<div id="mgAmortization"></div>

	</div><!-- end calculator results -->
    <script type="text/javascript" src="<?= base_url() ?>public/js/mg-calculator.js"></script>
</div>