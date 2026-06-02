pipeline {
    agent any

    options {
        timestamps()
        disableConcurrentBuilds()
    }

    environment {
        PATH = "/opt/homebrew/bin:/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/Applications/Docker.app/Contents/Resources/bin:${env.PATH}"
        DOCKERHUB_REPO = 'andaraleonhart/spk-smart'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm

                script {
                    env.COMMIT_SHORT = sh(
                        script: 'git rev-parse --short HEAD',
                        returnStdout: true
                    ).trim()

                    env.IMAGE_TAG = "${env.BUILD_NUMBER}-${env.COMMIT_SHORT}"
                }

                sh '''
                    echo "Commit: ${COMMIT_SHORT}"
                    echo "Image tag: ${IMAGE_TAG}"
                '''
            }
        }

        stage('Check Docker') {
            steps {
                sh '''
                    echo "PATH=$PATH"
                    which docker
                    docker version
                    docker ps
                '''
            }
        }

        stage('Build Docker Image') {
            steps {
                sh '''
                    docker build -t ${DOCKERHUB_REPO}:${IMAGE_TAG} .
                '''
            }
        }

        stage('Push to Docker Hub') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: '285e4f16-718a-49af-80e8-dd8c0e885071',
                        usernameVariable: 'DOCKERHUB_USERNAME',
                        passwordVariable: 'DOCKERHUB_TOKEN'
                    )
                ]) {
                    sh '''
                        echo "$DOCKERHUB_TOKEN" | docker login \
                          --username "$DOCKERHUB_USERNAME" \
                          --password-stdin

                        docker push ${DOCKERHUB_REPO}:${IMAGE_TAG}

                        docker logout
                    '''
                }
            }
        }
    }

    post {
        success {
            echo "SUCCESS: Image pushed to Docker Hub: ${DOCKERHUB_REPO}:${IMAGE_TAG}"
        }

        failure {
            echo "FAILED: Check Jenkins console log."
        }
    }
}