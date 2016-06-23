<?php defined('_JEXEC') or die('Restricted access');

//      JToolBarHelper::back();

$exportFilename = date('Y-m-d') . '_appliants_export' . '.csv';

JResponse::clearHeaders();

JResponse::setHeader('Pragma', 'public', true);
JResponse::setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT', true); // Date in the past
JResponse::setHeader('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT', true);
JResponse::setHeader('Cache-Control', 'no-store, no-cache, must-revalidate', true); // HTTP/1.1
JResponse::setHeader('Cache-Control: pre-check=0, post-check=0, max-age=0', true); // HTTP/1.1
JResponse::setHeader('Pragma', 'no-cache', true);
JResponse::setHeader('Expires', '0', true);
JResponse::setHeader('Content-Transfer-Encoding', 'none', true);
JResponse::setHeader('Content-Type', 'application/csv', true); // joomla will overwrite this...
JResponse::setHeader('Content-Disposition', 'attachment; filename="' . $exportFilename . '"', true);

// joomla overwrites content-type, we can't use JResponse::setHeader()
$d = JFactory::getDocument();
$d->setMimeEncoding('application/csv');

// stop output buffering or we will run out of memory with large tables.
ob_end_flush();

JResponse::sendHeaders();
$output = fopen('php://output', 'w');
fputcsv($output,
    array('WD', 'DIV', 'NAME', 'ADDRESS', 'ZIP', 'PHONE', 'EMAIL', 'PARTY', 'SOURCE',
    )
);

$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++) {
    $row = &$this->items[$i];
    fputcsv($output,
        array(
            $row->ward,
            $row->division,
            ($row->prefix ? $row->prefix . ' ' : '') . $row->first_name . ' ' . ($row->middle_name ? $row->middle_name . ' ' : '') . $row->last_name . ($row->suffix ? ' ' . $row->suffix : ''),
            $row->address1 . ($row->address2 ? ' ' . $row->address2 : ''),
            $row->postcode,
            $row->phone,
            $row->email,
            '',
            'website',
        )
    );
    $k = 1 - $k;
}
