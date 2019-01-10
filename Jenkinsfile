pipeline {
  agent any
  stages {
    stage('Dependencies') {
      parallel {
        stage('Composer') {
          agent {
            docker {
              image 'composer'
              args '-v ${COMPOSER_CACHE_DIR}:${COMPOSER_CACHE_DIR}'
              reuseNode true
            }
          }
          steps {
            sh 'composer install --prefer-dist --no-progress --no-interaction --optimize-autoloader'
          }
        }
      }
    }
    stage('Test: Unit') {
      agent {
        dockerfile {
          dir 'docker/php-xdebug'
          reuseNode true
        }
      }
      steps {
        sh 'vendor/bin/phpunit --log-junit=var/ci/unit.junit --coverage-clover=var/ci/clover.xml --coverage-text=var/ci/coverage.txt --coverage-html=var/ci'
        script {
          COVERAGE_PERCENTAGE = sh (
            script: "awk -F':' '/^  Lines:/{print \$2}' var/ci/coverage.txt | awk {'print \$1'}",
            returnStdout: true
          ).trim()

          if (COVERAGE_PERCENTAGE) {
            step([
              $class: 'GitHubCommitStatusSetter',
              contextSource: [
                $class: 'ManuallyEnteredCommitContextSource',
                context: "continuous-integration/jenkins/coverage"
              ],
              statusResultSource: [
                $class: 'ConditionalStatusResultSource',
                results: [[$class: 'AnyBuildResult', message: "${COVERAGE_PERCENTAGE}", state: 'SUCCESS']]
              ]
            ])
          }
        }
      }
      post {
        always {
          junit allowEmptyResults: true, testResults: 'var/ci/unit.junit'
          step([
            $class: 'CloverPublisher',
            cloverReportDir: 'var/ci',
            cloverReportFileName: 'clover.xml',
            healthyTarget: [
              conditionalCoverage: 100,
              methodCoverage: 100,
              statementCoverage: 100
            ],
            unhealthyTarget: [
              methodCoverage: 50,
              conditionalCoverage: 50,
              statementCoverage: 50
            ],
            failingTarget: [
              methodCoverage: 0,
              conditionalCoverage: 0,
              statementCoverage: 0
            ]
          ])
        }
      }
    }
  }
  environment {
    COMPOSER_CACHE_DIR = '/var/cache/composer'
    APP_ENV = 'dev'
    APP_DEBUG = '0'
  }
}
