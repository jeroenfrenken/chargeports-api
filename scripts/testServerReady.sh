#!/bin/bash
attempt_counter=0
max_attempts=36

until $(curl --output /dev/null --silent --head --fail http://localhost/api/doc); do
  if [ ${attempt_counter} -eq ${max_attempts} ];then
    echo "Max attempts reached"
    exit 1
  fi

  echo 'No response yet, retrying in 5 seconds'
  attempt_counter=$(($attempt_counter+1))
  sleep 5
done

#Extra sleep just in case
sleep 5
echo 'Server is available, proceeding to next step.'
