import { Test, TestingModule } from '@nestjs/testing';
import { INestApplication } from '@nestjs/common';
import { ChimoneyModule } from '../src/chimoney.module';
import { ChimoneyClientService } from '../src/chimoney.service';

describe('RedisClientService (integration)', () => {
  let app: INestApplication;

  beforeAll(async () => {
    const moduleFixture: TestingModule = await Test.createTestingModule({
      imports: [ChimoneyModule.register({ apiKey: 'none key' })],
    }).compile();

    app = moduleFixture.createNestApplication();
    await app.init();
  });

  describe('when application is running', () => {
    it('should have redis client ready', async () => {
      const chimoneyClientService: ChimoneyClientService = app.get(
        ChimoneyClientService,
      );
      expect(
        await chimoneyClientService.getTransactionsByIssueID({
          issueID: '',
          subAccount: '',
        }),
      ).toEqual('here  ');
    });
  });

  afterAll(async () => {
    await app.close();
  });
});
