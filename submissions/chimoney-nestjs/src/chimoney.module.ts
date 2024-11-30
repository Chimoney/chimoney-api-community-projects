// import { DynamicModule, Module } from '@nestjs/common';
import { ChimoneyClientService } from './chimoney.service';
// import { Config } from './config';
// import { CONFIG_OPTIONS } from './constants';
// import { TransactionsService } from './services/account';

// @Module({})
// export class ChimoneyModule {
//   static register(config: Config): DynamicModule {
//     return {
//       module: ChimoneyModule,
//       providers: [
//         {
//           provide: CONFIG_OPTIONS,
//           useValue: config,
//         },
//         // ChimoneyClientService,
//         TransactionsService,
//       ],
//       //   global: (config?.additionalOptions?.isGlobal || false),
//       exports: [ChimoneyClientService],
//     };
//   }
// }

import { DynamicModule, Module } from '@nestjs/common';
import { Config } from './config';
import {
  API_VERSION,
  AXIOS_INSTANCE,
  BASEURL,
  CONFIG_OPTIONS,
} from './constants';
import { AccountService } from './services/account';
import Axios from 'axios';

@Module({})
export class ChimoneyModule {
  static register(config: Config): DynamicModule {
    return {
      module: ChimoneyModule,
      providers: [
        {
          provide: CONFIG_OPTIONS,
          useValue: config,
        },
        {
          provide: AXIOS_INSTANCE,
          useFactory: () => {
            const axiosInstance = Axios.create({
              baseURL: `${BASEURL}/${config.apiVersion || API_VERSION}/`,
              headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': config.apiKey,
              },
            });
            return axiosInstance;
          },
        },
        ChimoneyClientService,
        AccountService,
      ],
      //   global: (config?.additionalOptions?.isGlobal || false),
      //   exports: [TransactionsService],
      exports: [ChimoneyClientService],
    };
  }
}
