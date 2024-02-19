
<?php
// Conecte-se ao banco de dados MongoDB
require '/laragon/www/projformulario/php/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost');
$databaseName = 'plataformaInqueritos';
$collectionName = 'questionarios';
$collection = $client->$databaseName->$collectionName;

// Receber os dados do formulário
$formData = $_POST;

// Remover campos adicionais não relacionados ao formulário
unset($formData['formTitle'], $formData['formEditor']);

// Processar dados do formulário
$newFormData = [
    'title' => $formData['formTitle']
];

foreach ($formData as $key => $value) {
    $typeKey = $key . 'Type';
    $type = $formData[$typeKey];

    $newField = [
        'question' => $value,
        'type' => $type
    ];

    if ($type === 'radio-group' || $type === 'evaluation-group') {
        $options = [];
        for ($i = 0; isset($formData[$key . 'Option' . $i]); $i++) {
            $options[] = $formData[$key . 'Option' . $i];
        }
        $newField['options'] = $options;
    }

    $newFormData[$key] = $newField;
}

// Salvar novo formulário no MongoDB
$collection->insertOne($newFormData);

// Redirecionar de volta para a página inicial
header("Location: edicao.php");
exit();
?>

