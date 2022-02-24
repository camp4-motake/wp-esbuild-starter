#!usr/bin/env zx

/**
 * wp-cli shortcut
 */
import { $ } from "zx";

const args = process.argv.slice(3).join(" ");

await $`docker-compose run --rm cli bash -c ${args}`;
