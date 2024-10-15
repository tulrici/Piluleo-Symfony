pipeline {
    agent any
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
        stage('Run Tests') {
            steps {
            sh '/usr/bin/phpunit'
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