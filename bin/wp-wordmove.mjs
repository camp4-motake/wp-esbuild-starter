#!usr/bin/env zx

/**
 * wordmove shortcut
 */
import { $ } from "zx";

const [command] = argv._;
const cmd = `cd /home && export RUBYOPT=-EUTF-8 && ${command}`;

await $`docker-compose run --rm wordmove bash -c ${cmd}`;
