<?php
/**
 * Memberships page template
 *
 * WordPress uses this file for the page with the slug "memberships"
 * (page-{slug}.php). It explains the annual Ukrainian Cheremosh Society
 * membership: what it includes, which one a family or dancer needs, the
 * four tiers and prices, and the renewal policy.
 *
 * There is no Figma design for this page, so it reuses the About page
 * banner (.about-hero) and the existing colours. Wording comes from the
 * client's copy document (section 1.5).
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<!--
		1. HERO BANNER
		Same layout as the About page banner. The photo is this page's
		Featured image, set in the page editor.
	-->
	<section class="about-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'full', array( 'class' => 'about-hero-image', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<div class="about-hero-text">
			<p class="about-hero-tagline">Cheremosh | Edmonton since 1969</p>
			<h1 class="about-hero-title about-hero-title--wide">Society Memberships</h1>
			<div class="about-hero-bottom">
				<p class="about-hero-description">Because Cheremosh is a community-run non-profit organization, every registering family and adult dancer begins by activating an annual Ukrainian Cheremosh Society membership.</p>
			</div>
		</div>
	</section>

	<!--
		2. WHAT YOUR MEMBERSHIP INCLUDES
		A list, because it is three items. Each one is a small card.
	-->
	<section class="memberships-includes" aria-labelledby="memberships-includes-heading">
		<div class="memberships-inner">

			<p class="about-label">Membership</p>
			<h2 id="memberships-includes-heading" class="memberships-title">What Your Annual Membership Includes</h2>
			<span class="about-rule" aria-hidden="true"></span>

			<ul class="memberships-includes-list">
				<li class="memberships-include">
					<h3 class="memberships-include-title">Access to School Registration</h3>
					<p>Unlocks registration pages for all Cheremosh School of Dance programs.</p>
				</li>
				<li class="memberships-include">
					<h3 class="memberships-include-title">Complimentary Concert Media</h3>
					<p>Includes a digital download of the School of Dance Year-End Concert and a professional individual and group photo for each enrolled dancer (with options to order additional prints).</p>
				</li>
				<li class="memberships-include">
					<h3 class="memberships-include-title">Member Discounts</h3>
					<p>Exclusive savings on Cheremosh Summer Dance Camps and select Society events and merchandise.</p>
				</li>
			</ul>
		</div>
	</section>

	<!--
		3. WHICH MEMBERSHIP DO YOU NEED?
		Two cards side by side (stacked on phones): youth dancers and adults.
	-->
	<section class="memberships-which" aria-labelledby="memberships-which-heading">
		<div class="memberships-inner">

			<h2 id="memberships-which-heading" class="memberships-title">Which Membership Do You Need?</h2>
			<span class="about-rule" aria-hidden="true"></span>

			<div class="memberships-which-grid">
				<article class="memberships-which-card">
					<p class="memberships-which-label">Dancer under age 18</p>
					<h3 class="memberships-which-name">Family Membership</h3>
					<p class="memberships-which-price">$50<span>/year</span></p>
					<p>You must select a Family Membership, which covers up to five immediate family members living in the same household. Individual Memberships do not unlock youth School of Dance registration pages.</p>
				</article>

				<article class="memberships-which-card">
					<p class="memberships-which-label">Adult dancers (18+) &amp; Company members</p>
					<h3 class="memberships-which-name">Individual Membership</h3>
					<p class="memberships-which-price">$25<span>/year</span></p>
					<p>Dancers aged 18 and older registering only themselves may select an Individual Membership.</p>
				</article>
			</div>
		</div>
	</section>

	<!--
		4. ALL MEMBERSHIP TIERS
		A real table, because it is rows and columns of data. The caption and
		scope="col" let screen readers announce which column each cell is in.
	-->
	<section class="memberships-tiers" aria-labelledby="memberships-tiers-heading">
		<div class="memberships-inner">

			<h2 id="memberships-tiers-heading" class="memberships-title">All Membership Tiers</h2>
			<span class="about-rule" aria-hidden="true"></span>

			<div class="memberships-table-wrap">
				<table class="memberships-table">
					<caption class="screen-reader-text">Membership tiers, annual fees and who each one covers</caption>
					<thead>
						<tr>
							<th scope="col">Membership Tier</th>
							<th scope="col">Annual Fee</th>
							<th scope="col">Coverage &amp; Eligibility</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Family Membership</th>
							<td>$50/year</td>
							<td>Up to 5 immediate family members; required for youth School registration</td>
						</tr>
						<tr>
							<th scope="row">Individual Membership</th>
							<td>$25/year</td>
							<td>Single adult (18+); valid for Chayka, Company, or general Society voting</td>
						</tr>
						<tr>
							<th scope="row">Alumni Family Membership</th>
							<td>$20/year</td>
							<td>Discounted family tier for former Cheremosh Company members</td>
						</tr>
						<tr>
							<th scope="row">Alumni Individual Membership</th>
							<td>$10/year</td>
							<td>Discounted individual tier for former Cheremosh Company members</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<!--
		5. RENEWAL & CANCELLATION
	-->
	<section class="memberships-renewal" aria-labelledby="memberships-renewal-heading">
		<div class="memberships-inner">

			<h2 id="memberships-renewal-heading" class="memberships-title">Renewal &amp; Cancellation Policy</h2>
			<span class="about-rule" aria-hidden="true"></span>

			<p class="memberships-renewal-text">Annual memberships renew automatically each year. You will receive an email reminder 10 days before your subscription renews. Membership fees are non-refundable. If you wish to cancel your membership prior to auto-renewal, log in to your account page and cancel your subscription before the renewal date.</p>
		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).