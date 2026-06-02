pipeline {
    agent any

    options {
        timestamps()
        disableConcurrentBuilds()
    }

    environment {
        DOCKERHUB_REPO = 'andaraleonhart/laravel12-app'
        IMAGE_TAG = "${env.BUILD_NUMBER}-${env.GIT_COMMIT.take(7)}"
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
                sh 'git rev-parse --short HEAD'
            }
        }

        stage('Check Docker') {
            steps {
                sh '''
                    docker version
                    docker ps
                '''
            }
        }

        stage('Build Docker Image') {
            steps {
                sh '''
                    docker build \
                      -t ${DOCKERHUB_REPO}:${IMAGE_TAG} \
                      -t ${DOCKERHUB_REPO}:latest \
                      .
                '''
            }
        }

        stage('Smoke Test Container') {
            steps {
                sh '''
                    docker rm -f laravel12-smoke || true

                    docker run -d --name laravel12-smoke -p 8099:80 \
                      -e APP_NAME=Laravel \
                      -e APP_ENV=production \
                      -e APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= \
                      -e APP_DEBUG=false \
                      -e APP_URL=http://localhost:8099 \
                      -e LOG_CHANNEL=stderr \
                      -e DB_CONNECTION=sqlite \
                      ${DOCKERHUB_REPO}:${IMAGE_TAG}

                    sleep 8

                    curl -f http://localhost:8099/up || \
                    (docker logs laravel12-smoke && exit 1)

                    docker rm -f laravel12-smoke
                '''
            }

            post {
                always {
                    sh 'docker rm -f laravel12-smoke || true'
                }
            }
        }

        stage('Push to Docker Hub') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'dockerhub-creds',
                        usernameVariable: 'andaraleonhart',
                        passwordVariable: 'dckr_pat_xxuRrJ7qAXXY8UpGDKZO2T-VrvQ'
                    )
                ]) {
                    sh '''
                        echo "$DOCKERHUB_TOKEN" | docker login \
                          --username "$DOCKERHUB_USERNAME" \
                          --password-stdin

                        docker push ${DOCKERHUB_REPO}:${IMAGE_TAG}
                        docker push ${DOCKERHUB_REPO}:latest

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

        always {
            sh 'docker image prune -f || true'
        }
    }
}