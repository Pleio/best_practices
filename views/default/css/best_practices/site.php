<?php ?>
#best-practices-sidebar-files .elgg-discover:hover .elgg-discoverable,
#best-practice-form-edit-attachtments-files .elgg-discover:hover .elgg-discoverable {
	display: inline-block;
}

.elgg-form-best-practices-edit .elgg-input-checkboxes label {
	font-size: 100%;
	line-height: 1.2em;
}

.elgg-icon-best-practices-filter {
	background: url("<?php echo elgg_get_site_url(); ?>mod/best_practices/_graphics/filter.png");
	cursor: pointer;
	margin: 0 0 0 10px;
}

.best-practices-table {
	table-layout:fixed;
}

.best-practices-table .best-practices-nowrap,
.best-practices-table th {
	white-space: nowrap;
	word-wrap: normal;
}

.best-practices-table-comments,
.best-practices-table-likes {
	width: 30px;
}

.best-practices-table ul.elgg-tags .elgg-icon {
	display: none;
}
.best-practices-table ul.elgg-tags .elgg-tag a {
	font-size: 12.8px;
}

.best-practices-align-right {
	text-align: right;
}

.best-practices-filter-input {
	display: none;
	padding: 0px;
	font-size: 100%;
}

.best-practices-sortable {
	cursor: pointer;
}

.best-practices-sortable.sorting-asc,
.best-practices-sortable.sorting-desc,
.best-practices-sortable:hover {
	text-decoration: underline;
}

.best-practices-sortable.sorting-desc .elgg-icon-speech-bubble {
	background-position: 0 -1116px;
}

.best-practices-sortable.sorting-desc .elgg-icon-thumbs-up {
	background-position: 0 -1350px;
}