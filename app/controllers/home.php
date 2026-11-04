<?php
/**
 * Home page controller — pulls all content from the database.
 */
$skills = db()->query('SELECT * FROM skills ORDER BY sort_order, id')->fetchAll();

$projects = db()->query('SELECT * FROM projects ORDER BY sort_order, id')->fetchAll();
// Attach links to each project.
$linkStmt = db()->prepare('SELECT * FROM project_links WHERE project_id = ? ORDER BY sort_order');
foreach ($projects as &$pr) {
    $linkStmt->execute([$pr['id']]);
    $pr['links'] = $linkStmt->fetchAll();
}
unset($pr);

$experiences = db()->query('SELECT * FROM experiences ORDER BY sort_order, id')->fetchAll();

view('home', [
    'skills'      => $skills,
    'projects'    => $projects,
    'experiences' => $experiences,
]);
