pipeline {
    agent any
    environment {
        DATABASE_URL = 'pgsql://symfony:symfony_password@localhost:5432/Pilulier_Test'
        PILULIER_API_BASE_URL = 'http://localhost:5000/pillbox'
        PILULIER_REMOTE_URL = 'http://localhost:5000/pillbox/remote'
    }
    services {
        postgres {
            image 'postgres:13'
            env {
                POSTGRES_DB = 'Pilulier_Test'
                POSTGRES_USER = 'symfony'
                POSTGRES_PASSWORD = 'symfony_password'
            }
            ports = ['5432:5432']
        }
        pillboxSimulator {
            image 'piluleo_hardware_simulator:latest'
            ports = ['5000:5000']
        }
    }
    stages {
        stage('Clone repository') {
            steps {
                withCredentials([string(credentialsId: 'github-token', variable: 'GITHUB_TOKEN')]) {
                    git branch: 'main', 
                        url: 'https://$GITHUB_TOKEN@github.com/tulrici/Piluleo-Symfony.git'
                }
            }
        }
        stage('Install dependencies') {
            steps {
                sh 'composer install'
            }
        }
        stage('Setup database') {
            steps {
                sh 'php bin/console doctrine:migrations:migrate --no-interaction'
            }
        }
        stage('Run Tests') {
            steps {
                sh './vendor/bin/phpunit --testdox --coverage-text'
            }
        }
    }
    post {
        success {
            echo 'Pipeline completed successfully!'
        }
        failure {
            echo 'Pipeline failed. Please check the logs.'
        }
    }
}