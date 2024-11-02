#!/bin/bash

# Export .env environment variables
export $(grep -v '^#' .env | xargs -d '\n')

if [ -z "$REGISTRATION_TOKEN" ]
then
  echo "Please provide a registration token."
  exit 1
fi

# Unregister existing runners.
docker exec ischool-backend-runner-container /bin/bash -c "gitlab-runner unregister --all-runners"

# Register a runner.
docker exec ischool-backend-runner-container /bin/bash -c "gitlab-runner register \
    --non-interactive \
    --url $CI_SERVER_URL \
    --registration-token $REGISTRATION_TOKEN \
    --executor docker \
    --description $RUNNER_NAME \
    --docker-image "docker:stable" \
    --docker-volumes /var/run/docker.sock:/var/run/docker.sock"

# Verify registrated runner
docker exec ischool-backend-runner-container /bin/bash -c "gitlab-runner verify"
