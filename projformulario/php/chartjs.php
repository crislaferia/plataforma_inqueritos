<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise de Dados</title>
    <!-- Incluindo o Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Incluindo o DataTables e jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <div>
        <h2>Respostas dos Formulários</h2>
        <table id="responseTable" class="display">
            <thead>
                <tr>
                    <th>Formulário</th>
                    <th>Questão</th>
                    <th>Resposta</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dados das respostas serão preenchidos dinamicamente aqui -->
            </tbody>
        </table>
    </div>
    <div>
        <h2>Análise dos Dados</h2>
        <canvas id="analysisChart" width="400" height="400"></canvas>
    </div>

    <script>
        // Função para preencher a tabela de respostas dos formulários
        function fillResponseTable(dataArray) {
            var table = $('#responseTable').DataTable({
                paging: false,
                searching: false,
                ordering: false
            });

            dataArray.forEach(function(data) {
                var responses = data.responses;
                Object.keys(responses).forEach(function(questionKey) {
                    var question = responses[questionKey].question;
                    var answer = responses[questionKey].answer;
                    table.row.add([data.title, question, answer]).draw();
                });
            });
        }

        // Função para realizar a análise dos dados e criar o gráfico
        function analyzeData(dataArray) {
            var responseData = {};

            // Contar as respostas
            dataArray.forEach(function(data) {
                var responses = data.responses;
                Object.keys(responses).forEach(function(questionKey) {
                    var response = responses[questionKey].answer;
                    if (!responseData[questionKey]) {
                        responseData[questionKey] = {};
                    }
                    if (!responseData[questionKey][response]) {
                        responseData[questionKey][response] = 1;
                    } else {
                        responseData[questionKey][response]++;
                    }
                });
            });

            // Construir dados para o gráfico
            var labels = [];
            var datasets = [];

            Object.keys(responseData).forEach(function(questionKey) {
                var question = dataArray[0].responses[questionKey].question;
                var answers = Object.keys(responseData[questionKey]);
                var data = [];

                answers.forEach(function(answer) {
                    data.push(responseData[questionKey][answer]);
                });

                labels.push(question);
                datasets.push({
                    label: question,
                    data: data,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                });
            });

            // Criar o gráfico
            var ctx = document.getElementById('analysisChart').getContext('2d');
            var analysisChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Exemplo de dados dinâmicos
        var jsonDataArray = [
            {
                "title": "Formulario Mod Teste 1",
                "responses": {
                    "1:": {
                        "question": "O que achaste deste projeto?",
                        "answer": "Interessante"
                    },
                    "2:": {
                        "question": "Voltarias a fazer este projeto?",
                        "answer": "Sim"
                    },
                    "3:": {
                        "question": "O que achaste deste módulo?",
                        "answer": "4"
                    },
                    "4:": {
                        "question": "Algum comentário adicional?",
                        "answer": "Podia ter bases"
                    }
                }
            },
            {
                "title": "Formulario Mod Teste 2",
                "responses": {
                    "1:": {
                        "question": "O que achaste deste projeto?",
                        "answer": "Muito bom"
                    },
                    "2:": {
                        "question": "Voltarias a fazer este projeto?",
                        "answer": "Sim"
                    },
                    "3:": {
                        "question": "O que achaste deste módulo?",
                        "answer": "5"
                    },
                    "4:": {
                        "question": "Algum comentário adicional?",
                        "answer": "Teve bases sólidas"
                    }
                }
            },
            {
        "title": "Formulario Mod Teste 4",
        "responses": {
            "1:": {
                "question": "O que achaste deste projeto?",
                "answer": "Interessante"
            },
            "2:": {
                "question": "Voltarias a fazer este projeto?",
                "answer": "Sim"
            },
            "3:": {
                "question": "O que achaste deste módulo?",
                "answer": "4"
            },
            "4:": {
                "question": "Algum comentário adicional?",
                "answer": "Podia ter bases"
            }
        }
    },
    {
        "title": "Formulario Mod Teste 5",
        "responses": {
            "1:": {
                "question": "O que achaste deste projeto?",
                "answer": "Muito bom"
            },
            "2:": {
                "question": "Voltarias a fazer este projeto?",
                "answer": "Sim"
            },
            "3:": {
                "question": "O que achaste deste módulo?",
                "answer": "5"
            },
            "4:": {
                "question": "Algum comentário adicional?",
                "answer": "Teve bases sólidas"
            }
        }
    },
    {
        "title": "Formulario Mod Teste 6",
        "responses": {
            "1:": {
                "question": "O que achaste deste projeto?",
                "answer": "Regular"
            },
            "2:": {
                "question": "Voltarias a fazer este projeto?",
                "answer": "Não"
            },
            "3:": {
                "question": "O que achaste deste módulo?",
                "answer": "3"
            },
            "4:": {
                "question": "Algum comentário adicional?",
                "answer": "Faltou material complementar"
            }
        }
    }
        ];;

        // Preencher a tabela de respostas dos formulários
        fillResponseTable(jsonDataArray);

        // Realizar a análise dos dados
        analyzeData(jsonDataArray);
    </script>
</body>
</html>
