#!usr/bin/env zx

/**
 * wp-cli setup shortcut
 */
import { $, argv } from "zx";

const sleep = argv.sleep || 10;

await $`docker compose up -d && sleep ${sleep}`;
await $`docker compose run --rm --user root cli bash -c /html/setup.sh`;
