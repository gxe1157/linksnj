	<link rel="stylesheet"  href="<?= base_url() ?>public/css/mg-light-simplistic.css" />

	<link rel="stylesheet"  href="<?= base_url() ?>public/css/mg-main.css" />

    <script src="<?= base_url() ?>public/app/controllers/recent-properties-controller.js"></script>







<div ng-controller="recentPropertiesController as rc"> 



<!-- loading -->

<div class="loader" ng-show="rc.recentLoading">Loading...</div>

<h2 class="sub-heading text-center">Recent properties</h2>

<!-- Loop over results -->

<div class="col-sm-12 ng-hide" ng-repeat="recent in rc.recentProps" ng-show="!rc.recentLoading">

    <div class="item-wrap">

        <div class="property-item item-grid">

            <div class="figure-block">

                <figure class="item-thumb">

                    <div class="label-wrap hide-on-list">

                        <div class="label-status label label-default">For Sale</div>

                    </div>

                    <span class="label-featured label label-success">Featured</span>

                    <div class="price hide-on-list black-bg">

                        <h3 ng-bind="recent.PRICECURRENT | currency"></h3>

                    </div>

                    <a href="/view-property?type=RES&id={{::recent.LISTINGID}}">

                        <img ng-src="{{recent.photos}}" onerror="this.src='<?= base_url() ?>public/images/links-loading.jpg'" alt="thumb">

                    </a>

                    <figcaption class="thumb-caption cap-actions clearfix">

                        <div class="pull-right">

                            <ul class="list-unstyled actions">

                                <li class="share-btn">

                                    <div class="share_tooltip fade">

                                        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>

                                        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>

                                        <a href="#" target="_blank"><i class="fa fa-google-plus"></i></a>

                                        <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>

                                    </div>

                                    <span data-toggle="tooltip" data-placement="top" title="share"><i class="fa fa-share-alt"></i></span>

                                </li>

                                <li>

                                    <span data-toggle="tooltip" data-placement="top" title="Favorite">

                                        <i class="fa fa-heart-o"></i>

                                    </span>

                                </li>

                                <li>

                                    <span data-toggle="tooltip" data-placement="top" title="Photos (12)">

                                        <i class="fa fa-camera"></i>

                                    </span>

                                </li>

                            </ul>

                        </div>

                    </figcaption>

                </figure>

            </div>

            <div class="item-body">



                <div class="body-left">

                    <div class="info-row">

                        <h2 class="property-title">

                            <a href="#">

                                <span ng-bind="recent.STREETNUM"></span>

                                <span ng-bind="recent.STREET"></span>

                                <span ng-bind="recent.STREETTYP"></span>,

                                <span ng-bind="recent.AREANAME"></span>

                            </a>

                        </h2>

                    </div>

                    <div class="table-list full-width info-row">

                        <div class="cell">

                            <div class="info-row amenities">

                                <p>

                                    <span ng-bind="'Rooms: ' + recent.NUMROOMS"></span>

                                    <span ng-bind="'Beds: ' + recent.BDRMS"></span>

                                    <span ng-bind="'Baths: ' + recent.BATHSFULL"></span>

                                </p>

                                <p ng-bind="'Type: ' + recent.SUBSTYLE"></p>

                            </div>

                        </div>

                        <div class="cell">

                            <div class="phone">

                                <a href="/view-property?type=RES&id={{::recent.LISTINGID}}" class="btn btn-primary">Details <i class="fas fa-info-circle"></i></a>

                                <p><a href="#">+1 (786) 225-0199</a></p>

                            </div>

                        </div>

                    </div>

                </div>



            </div>

        </div>

        <div class="item-foot date hide-on-list">

            <div class="item-foot-left">

                <p><i class="fa fa-user"></i> <a href="#">Links Residential</a></p>

            </div>

        </div>

    </div>

</div>

<div style="clear:both"></div>

 </div>







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

			<div class="mg-calculator-item-container">

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