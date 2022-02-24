#!usr/bin/env zx

/**
 * wordmove shortcut
 */
import { $ } from "zx";

const args = process.argv.slice(3).join(" ");
const cmd = `cd /home && export RUBYOPT=-EUTF-8 && ` + args;

await $`docker-compose run --rm cli bash -c ${cmd}`;
